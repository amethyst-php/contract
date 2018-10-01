<?php

namespace Railken\Amethyst\Issuer;

use DateInterval;
use DateTime;
use Railken\Amethyst\Contracts\IssuerContract;
use Railken\Amethyst\Managers\InvoiceItemManager;
use Railken\Amethyst\Managers\InvoiceManager;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Models\ContractService;
use Railken\Amethyst\Models\Invoice;
use Railken\Amethyst\Models\InvoiceItem;

class BaseIssuer implements IssuerContract
{
    /**
     * @var Contract
     */
    protected $contract;

    /**
     * @param Contract $contract
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return DateTime
     */
    public function today()
    {
        return (new DateTime())->setTime(00, 00, 00);
    }

    /**
     * @return bool
     */
    public function canIssue()
    {
        $now = new DateTime();

        return !$this->contract->next_bill_at || $this->contract->next_bill_at < $now;
    }

    /**
     * Issue invoice.
     *
     * @param Invoice $invoice
     */
    public function issueInvoice($invoice)
    {
        $manager = new InvoiceManager();
        $manager->issue($invoice);
    }

    /**
     * @return Invoice
     */
    public function createInvoice()
    {
        $manager = new InvoiceManager();
        $contract = $this->contract;

        return $manager->createOrFail([
            'country'      => $contract->country,
            'locale'       => $contract->locale,
            'currency'     => $contract->currency,
            'tax_id'       => $contract->tax->id,
            'recipient_id' => $contract->customer->id,
            'sender_id'    => $contract->customer->id, // ToDO: base config with base entity local id
            'expires_at'   => $this->today()->modify('+14 days')->format('Y-m-d H:i:s'),
        ])->getResource();
    }

    /**
     * Calculate an approximation of "per single price day".
     *
     * @param ContractService $service
     *
     * @return float
     */
    public function calculateSinglePriceDay(ContractService $service)
    {
        if ($service->frequency_unit === 'days') {
            return $service->price;
        }

        if ($service->frequency_unit === 'weeks') {
            return $service->price / 7;
        }

        if ($service->frequency_unit === 'months') {
            return $service->price / 30;
        }

        if ($service->frequency_unit === 'years') {
            return $service->price / 365;
        }
    }

    /**
     * @param Invoice         $invoice
     * @param ContractService $service
     * @param DateInterval    $diff
     *
     * @return InvoiceItem
     */
    public function createInvoiceItem(Invoice $invoice, ContractService $service, DateInterval $diff)
    {
        $manager = new InvoiceItemManager();
        $contract = $this->contract;

        // Service has always the same frequency_unit and the result must be always be without rest
        $ratio = $service->contract->frequency_value / $service->frequency_value;
        $price = $service->price * $ratio;

        $single_day = $this->calculateSinglePriceDay($service);

        $price = round($price + $diff->days * $single_day, 2, PHP_ROUND_HALF_UP);

        return $manager->createOrFail([
            'name'        => $service->code,
            'unit_name'   => 'u',
            'description' => '/',
            'quantity'    => 1,
            'price'       => (string) $price,
            'tax_id'      => $service->tax->id,
            'invoice_id'  => $invoice->id,
        ]);
    }

    /**
     * Validate.
     */
    public function validate()
    {
        $contract = $this->contract;

        if (!$this->canIssue()) {
            throw new \Exception('Cannot perform bill');
        }

        if (!$contract->starts_at) {
            throw new \Exception('Missing starts at');
        }

        if ($contract->ends_at && $contract->ends_at < $this->today()) {
            throw new \Exception('Already ended?');
        }
    }

    /**
     * Issue.
     */
    public function issue()
    {
        $contract = $this->contract;

        $this->validate();

        $last = $contract->last_bill_at;

        if (!$last) {
            $last = $contract->starts_at;
        }

        $diff = $last->modify(sprintf('+ %s %s', $contract->frequency_value, $contract->frequency_unit))->diff($this->today());

        if ($diff->invert === 1) {
            return;
        }

        $invoice = $this->createInvoice();

        foreach ($contract->services as $service) {
            $this->createInvoiceItem($invoice, $service, $diff);
        }

        $next = $this->today()->modify(sprintf('+ %s %s', $contract->frequency_value, $contract->frequency_unit));

        $contract->last_bill_at = $this->today();
        $contract->next_bill_at = $next;

        $this->issueInvoice($invoice);
        ++$contract->renewals;
        $contract->save();
    }
}
