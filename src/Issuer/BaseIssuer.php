<?php

namespace Railken\Amethyst\Issuer;

use DateInterval;
use DateTime;
use Railken\Amethyst\Contracts\IssuerContract;
use Railken\Amethyst\Managers\InvoiceItemManager;
use Railken\Amethyst\Managers\InvoiceManager;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Models\ContractProduct;
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
     * @param Invoice         $invoice
     * @param ContractProduct $product
     * @param DateInterval    $diff
     *
     * @return InvoiceItem
     */
    public function createInvoiceItem(Invoice $invoice, ContractProduct $product, DateInterval $diff)
    {
        $manager = new InvoiceItemManager();
        $contract = $this->contract;

        $price_rule = $product->sellable_catalogue->price_rule;

        // This should be handled as subscription
        if ($price_rule->class_name instanceof \Railken\Amethyst\PriceRules\FrequencyPriceRule) {
        }

        // This should be handled as subscription
        if ($price_rule->class_name instanceof \Railken\Amethyst\PriceRules\FrequencyPriceRule) {
        }

        // Product has always the same frequency_unit and the result must be always be without rest
        $ratio = $product->contract->frequency_value / $product->sellable_catalogue->price_rule->frequency_value;
        $price = $product->price * $ratio;

        $single_day = $this->calculateSinglePriceDay($product);

        $price = round($price + $diff->days * $single_day, 2, PHP_ROUND_HALF_UP);

        return $manager->createOrFail([
            'name'        => $product->code,
            'unit_name'   => 'u',
            'description' => '/',
            'quantity'    => 1,
            'price'       => (string) $price,
            'tax_id'      => $product->tax->id,
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

        foreach ($contract->products as $product) {
            $this->createInvoiceItem($invoice, $product, $diff);
        }

        $next = $this->today()->modify(sprintf('+ %s %s', $contract->frequency_value, $contract->frequency_unit));

        $contract->last_bill_at = $this->today();
        $contract->next_bill_at = $next;

        $this->issueInvoice($invoice);
        ++$contract->renewals;
        $contract->save();
    }
}
