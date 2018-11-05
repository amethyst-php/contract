<?php

namespace Railken\Amethyst\Consumers;

use Illuminate\Support\Collection;
use Railken\Amethyst\Contracts\IssuerContract;
use Railken\Amethyst\Managers\ContractProductConsumeManager;
use Railken\Amethyst\Managers\SellableProductCatalogueManager;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Models\ContractProduct;
use Railken\Amethyst\Models\InvoiceItem;
use Railken\Amethyst\Models\SellableProductCatalogue;
use Railken\Amethyst\Schemas\ContractProductSchema;
use Railken\Amethyst\Schemas\ContractSchema;
use Railken\Bag;

class BaseConsumer implements IssuerContract
{
    /**
     * Find all the prices connected to a single product.
     *
     * @param ContractProduct $contractProduct
     *
     * @return Collection
     */
    public function findPricesSellableProductByCatalogue(ContractProduct $contractProduct)
    {
        $m = new SellableProductCatalogueManager();

        return $m->getRepository()->findBy([
            'target_id'    => $contractProduct->contract->target->id,
            'catalogue_id' => $contractProduct->catalogue->id,
            'product_id'   => $contractProduct->product->id,
        ]);
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

        $consume_rule = $sellableProductCatalogue->consume_rule;
        $class_name = $consume_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\ConsumeRules\BaseConsumeRule) {
            if (intval($contractProduct->renewals) === 0) {
                $items->push(new Bag([
                    'sellable_product'  => $sellableProductCatalogue,
                    'contract_product'  => $contractProduct,
                    'value'             => $rule->calculate($consume_rule),
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
     * @param ContractProduct          $product
     * @param SellableProductCatalogue $sellableProductCatalogue
     *
     * @return bool
     */
    public function shouldCreateFirstProductConsumed(ContractProduct $contractProduct, SellableProductCatalogue $sellableProductCatalogue)
    {
        return true;
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

        $consume_rule = $sellableProductCatalogue->consume_rule;
        $class_name = $consume_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\ConsumeRules\FrequencyConsumeRule) {
            // Retrieve last created_at for the same product;

            $cpm = new ContractProductConsumeManager();

            $last = $cpm->getRepository()->newQuery()->where([
                'contract_product_id' => $contractProduct->id,
                'sellable_product_id' => $sellableProductCatalogue->id,
            ])->orderBy('created_at', 'DESC')->first();

            $value = null;

            if (!$last && $this->shouldCreateFirstProductConsumed($contractProduct, $sellableProductCatalogue)) {
                $value = 1;
            } else {
                $payload = $rule->payload;

                $start = $last->created_at;

                // We always want to consume products until the next cycle;
                $now = (new \DateTime());

                // We assume the consumer is always up, so if more than one cycle has passed we will make no adjustments.
                $diff = $start->diff($now);
                $cyclePassed = $rule->getDateIntervalPropertyByUnit($diff, $payload->frequency_unit) / $payload->frequency_value;

                // If the previous values was 0.80, we will wait only 0.80 time to consume again the recurrent product.
                if ($cyclePassed >= $value) {
                    $value = 1;
                }
            }

            if ($value) {
                $items->push(new Bag([
                    'sellable_product'  => $sellableProductCatalogue,
                    'contract_product'  => $contractProduct,
                    'value'             => $value,
                ]));
            }
        }

        return $items;
    }

    /**
     * @param ContractProduct $product
     *
     * @return InvoiceItem
     */
    public function createItem(ContractProduct $contractProduct)
    {
        $items = new Collection();

        $sellableProductCatalogues = $this->findPricesSellableProductByCatalogue($contractProduct);

        foreach ($sellableProductCatalogues as $sellableProductCatalogue) {
            // OneTimeProduct should be added manually
            // $items = $items->merge($this->handleOneTimeProduct($contractProduct, $sellableProductCatalogue));
            $items = $items->merge($this->handleRecurringProduct($contractProduct, $sellableProductCatalogue));
        }

        return $items;
    }

    /**
     * Retrieve a collection of products that have to be issued.
     *
     * @param Contract $contract
     *
     * @return Collection
     */
    public function getItemsToConsume(Contract $contract)
    {
        $items = new Collection();

        // A contract is only a container of products
        foreach ($contract->products as $product) {
            if ($product->status === ContractProductSchema::STATUS_STARTED) {
                $items = $items->merge($this->createItem($target, $product));
            }
        }

        return $items;
    }

    /**
     * Issue.
     *
     * @param Contract $contract
     */
    public function consume(Contract $contract)
    {
        if ($contract->status !== ContractSchema::STATUS_STARTED) {
            return null;
        }

        $items = $this->getItemsToConsume($target, $contract);

        if ($items->count() > 0) {
            $cpm = new ContractProductConsumeManager();

            foreach ($items as $item) {
                $cpm->createOrFail([
                    'contract_id'         => $contract->id,
                    'contract_product_id' => $item->get('contract_product')->id,
                    'sellable_product_id' => $item->get('sellable_product')->id,
                    'value'               => $item->get('value'),
                ]);
            }
        }

        return null;
    }
}
