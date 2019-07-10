<?php

namespace Amethyst\Issuer;

use Amethyst\Contracts\IssuerContract;
use Amethyst\Managers\ContractProductConsumeManager;
use Amethyst\Managers\InvoiceContainerManager;
use Amethyst\Managers\InvoiceItemManager;
use Amethyst\Managers\InvoiceManager;
use Amethyst\Managers\TaxonomyManager;
use Amethyst\Models\Contract;
use Amethyst\Models\ContractProductConsume;
use Amethyst\Models\Invoice;
use Amethyst\Models\InvoiceContainer;
use Amethyst\Models\InvoiceItem;
use Amethyst\Models\LegalEntity;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class BaseIssuer implements IssuerContract
{
    public function getBillTo()
    {
        return new DateTime();
    }

    /**
     * @param Contract $contract
     *
     * @return bool
     */
    public function canIssue(Contract $contract)
    {
        return true;
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
     * @param \Amethyst\Models\LegalEntity $sender
     * @param \Amethyst\Models\Contract    $contract
     *
     * @return \Amethyst\Models\Invoice
     */
    public function createInvoice(LegalEntity $sender, Contract $contract)
    {
        $manager = new InvoiceManager();

        $params = [
            'country'      => $contract->country,
            'locale'       => $contract->locale,
            'currency'     => $contract->currency,
            'tax_id'       => $contract->tax->id,
            'recipient_id' => $contract->customer->legal_entity->id,
            'sender_id'    => $sender->id,
        ];

        $invoice = $manager->getRepository()->newQuery()->whereNull('issued_at')->where($params)->first();

        return $invoice ? $invoice : $manager->findOrCreateOrFail($params)->getResource();
    }

    public function getParentInvoiceUnit()
    {
        $tm = new TaxonomyManager();

        return $tm->findOrCreate(['name' => Config::get('amethyst.invoice.taxonomies.1.name')])->getResource();
    }

    /**
     * @param \Amethyst\Models\Invoice                $invoice
     * @param \Amethyst\Models\InvoiceContainer       $invoiceContainer
     * @param \Amethyst\Models\ContractProductConsume $contractProductConsume
     *
     * @return InvoiceItem
     */
    public function createInvoiceItem(Invoice $invoice, InvoiceContainer $invoiceContainer, ContractProductConsume $contractProductConsume)
    {
        $manager = new InvoiceItemManager();

        $tm = new TaxonomyManager();

        return $manager->createOrFail([
            'name'                 => $contractProductConsume->product->code,
            'unit_id'              => $tm->findOrCreate(['name' => 'u', 'parent_id' => $this->getParentInvoiceUnit()->id])->getResource()->id,
            'description'          => strval($contractProductConsume->notes),
            'quantity'             => 1,
            'price'                => round($contractProductConsume->price, 2, PHP_ROUND_HALF_UP),
            'tax_id'               => $contractProductConsume->tax->id,
            'invoice_id'           => $invoice->id,
            'invoice_container_id' => $invoiceContainer->id,
        ])->getResource();
    }

    /**
     * @param \Amethyst\Models\Invoice $invoice
     * @param string                   $name
     *
     * @return InvoiceItem
     */
    public function createInvoiceContainer(Invoice $invoice, string $name)
    {
        $manager = new InvoiceContainerManager();

        return $manager->findOrCreateOrFail([
            'name'       => $name,
            'invoice_id' => $invoice->id,
        ])->getResource();
    }

    /**
     * Retrieve a collection of products that have to be issued.
     *
     * @return Collection
     */
    public function getItemsToIssue(Contract $contract)
    {
        $cpm = new ContractProductConsumeManager();

        return $cpm->getRepository()->newQuery()->where([
            'contract_id' => $contract->id,
        ])->whereNull('billed_at')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Issue.
     *
     * @param LegalEntity $sender
     * @param Contract    $contract
     */
    public function issue(LegalEntity $sender, Contract $contract)
    {
        $contractProductConsumes = $this->getItemsToIssue($contract);

        if ($contractProductConsumes->count() > 0) {
            $invoice = $this->createInvoice($sender, $contract);

            foreach ($contractProductConsumes as $contractProductConsume) {
                $invoiceContainer = $this->createInvoiceContainer($invoice, $contractProductConsume->group->name);
                $invoiceItem = $this->createInvoiceItem($invoice, $invoiceContainer, $contractProductConsume);

                $contractProductConsume->billed_at = new \DateTime();
                $contractProductConsume->save();
            }

            $this->issueInvoice($invoice);
            $contract->save();

            return $invoice;
        }

        return null;
    }
}
