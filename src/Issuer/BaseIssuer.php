<?php

namespace Railken\Amethyst\Issuer;

use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Contracts\IssuerContract;
use Railken\Amethyst\Managers\InvoiceItemManager;
use Railken\Amethyst\Managers\InvoiceManager;
use Railken\Amethyst\Managers\SellableProductCatalogueManager;
use Railken\Amethyst\Managers\TaxonomyManager;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Models\ContractProduct;
use Railken\Amethyst\Models\Invoice;
use Railken\Amethyst\Models\InvoiceItem;
use Railken\Amethyst\Models\LegalEntity;
use Railken\Amethyst\Models\SellableProductCatalogue;
use Railken\Amethyst\Models\Target;
use Railken\Bag;

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
     * @param LegalEntity $sender
     * @param Contract    $contract
     *
     * @return Invoice
     */
    public function createInvoice(LegalEntity $sender, Contract $contract)
    {
        $manager = new InvoiceManager();

        return $manager->createOrFail([
            'country'      => $contract->country,
            'locale'       => $contract->locale,
            'currency'     => $contract->currency,
            'tax_id'       => $contract->tax->id,
            'recipient_id' => $contract->customer->legal_entity->id,
            'sender_id'    => $sender->id, // ToDO: base config with base entity local id
            'expires_at'   => (new \DateTime())->modify('+14 days')->format('Y-m-d H:i:s'),
        ])->getResource();
    }

    public function getParentInvoiceUnit()
    {
        $tm = new TaxonomyManager();

        return $tm->findOrCreate(['name' => Config::get('amethyst.invoice.managers.invoice-item.unit_taxonomy')])->getResource();
    }

    /**
     * @param Invoice $invoice
     * @param mixed   $item
     *
     * @return InvoiceItem
     */
    public function createInvoiceItem(Invoice $invoice, $item)
    {
        $manager = new InvoiceItemManager();

        $tm = new TaxonomyManager();

        return $manager->createOrFail([
            'name'        => $item->get('sellable')->product->code,
            'unit_id'     => $tm->findOrCreate(['name' => 'u', 'parent_id' => $this->getParentInvoiceUnit()->id])->getResource()->id,
            'description' => $item->get('notes'),
            'quantity'    => 1,
            'price'       => round($item->get('price'), 2, PHP_ROUND_HALF_UP),
            // 'tax_id'      => $product->tax->id,
            'invoice_id'  => $invoice->id,
        ])->getResource();
    }

    /**
     * Find all the prices connected to a single product.
     *
     * @param Target          $target
     * @param ContractProduct $contractProduct
     *
     * @return Collection
     */
    public function findPricesSellableProductByCatalogue(Target $target, ContractProduct $contractProduct)
    {
        $m = new SellableProductCatalogueManager();

        return $m->getRepository()->findBy([
            'target_id'    => $target->id,
            'catalogue_id' => $contractProduct->catalogue->id,
            'product_id'   => $contractProduct->product->id,
        ]);
    }

    /**
     * @param ContractProduct          $product
     * @param SellableProductCatalogue $sellableProductCatalogue
     * @param int                      $time
     *
     * @return string
     */
    public function getLabelFullCycleRecurringProduct(ContractProduct $contractProduct, SellableProductCatalogue $sellableProductCatalogue)
    {
        return 'RECURRING';
    }

    /**
     * @param ContractProduct          $product
     * @param SellableProductCatalogue $sellableProductCatalogue
     *
     * @return string
     */
    public function getLabelOneTimeProduct(ContractProduct $contractProduct, SellableProductCatalogue $sellableProductCatalogue)
    {
        return 'LUMP SUM';
    }

    /**
     * Handle One Time Product.
     *
     * @param ContractProduct          $product
     * @param SellableProductCatalogue $sellableProductCatalogue
     *
     * @return Collection
     */
    public function handleOneTimeProduct(ContractProduct $contractProduct, SellableProductCatalogue $sellableProductCatalogue)
    {
        $items = new Collection();

        $price_rule = $sellableProductCatalogue->price_rule;
        $class_name = $price_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\PriceRules\BasePriceRule) {
            if ($contractProduct->renewals === 0) {
                // $contractProduct->renewals = 1;
                // $contractProduct->save();

                $items->push(new Bag([
                    'price'    => $rule->calculate($price_rule, $sellableProductCatalogue->price),
                    'sellable' => $sellableProductCatalogue,
                    'notes'    => $this->getLabelOneTimeProduct($contractProduct, $sellableProductCatalogue),
                ]));
            }
        }

        return $items;
    }

    /**
     * Display time.
     *
     * @param int $seconds
     *
     * @return string
     */
    public function displayTime(int $seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }

    /**
     * Handle One Time Product.
     *
     * @param ContractProduct          $product
     * @param SellableProductCatalogue $sellableProductCatalogue
     *
     * @return Collection
     */
    public function handleRecurringProduct(ContractProduct $contractProduct, SellableProductCatalogue $sellableProductCatalogue)
    {
        $items = new Collection();

        $price_rule = $sellableProductCatalogue->price_rule;
        $class_name = $price_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\PriceRules\FrequencyPriceRule) {
            $last = $contractProduct->last_bill_at ? $contractProduct->last_bill_at : $contractProduct->starts_at;

            if (!$last) {
                throw new \Exception('Missing $last');
            }

            $price = $rule->calculate($price_rule, $sellableProductCatalogue->price, ['start' => $last, 'end' => $this->getBillTo()]);

            if ($price !== null) {
                $items->push(new Bag([
                    'price'    => $price,
                    'sellable' => $sellableProductCatalogue,
                    'notes'    => $this->getLabelFullCycleRecurringProduct($contractProduct, $sellableProductCatalogue),
                ]));
            }
        }

        return $items;
    }

    /**
     * @param Target          $target
     * @param ContractProduct $product
     *
     * @return InvoiceItem
     */
    public function createItem(Target $target, ContractProduct $contractProduct)
    {
        $items = new Collection();

        $sellableProductCatalogues = $this->findPricesSellableProductByCatalogue($target, $contractProduct);

        foreach ($sellableProductCatalogues as $sellableProductCatalogue) {
            $items = $items->merge($this->handleOneTimeProduct($contractProduct, $sellableProductCatalogue));
            $items = $items->merge($this->handleRecurringProduct($contractProduct, $sellableProductCatalogue));
        }

        return $items;
    }

    /**
     * Retrieve the date of the last bill.
     *
     * @param Contract $contract
     *
     * @return \DateTime
     */
    public function getLastBillAt(Contract $contract)
    {
        $last = $contract->last_bill_at;

        if (!$last) {
            $last = $contract->starts_at;
        }

        return $last;
    }

    /**
     * Retrieve a collection of products that have to be issued.
     *
     * @param Target $target
     *
     * @return Collection
     */
    public function getItemsToIssue(Target $target, Contract $contract)
    {
        $items = new Collection();

        // A contract is only a container of products
        foreach ($contract->products as $product) {
            $items = $items->merge($this->createItem($target, $product));
        }

        return $items;
    }

    /**
     * Issue.
     *
     * @param LegalEntity $sender
     * @param Target      $target
     * @param Contract    $contract
     */
    public function issue(LegalEntity $sender, Target $target, Contract $contract)
    {
        $items = $this->getItemsToIssue($target, $contract);

        if ($items->count() > 0) {
            $invoice = $this->createInvoice($sender, $contract);

            foreach ($items as $item) {
                $invoiceItem = $this->createInvoiceItem($invoice, $item);
            }

            $this->issueInvoice($invoice);

            return $invoice;
        }

        return null;
    }
}
