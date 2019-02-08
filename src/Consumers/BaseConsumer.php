<?php

namespace Railken\Amethyst\Consumers;

use Illuminate\Support\Collection;
use Railken\Amethyst\Contracts\IssuerContract;
use Railken\Amethyst\Managers\ContractProductConsumeManager;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Models\ContractProduct;
use Railken\Amethyst\Models\InvoiceItem;
use Railken\Amethyst\Models\Price;
use Railken\Amethyst\Schemas\ContractProductSchema;
use Railken\Amethyst\Schemas\ContractSchema;
use Railken\Bag;

class BaseConsumer implements IssuerContract
{
    /**
     * Handle One Time Product.
     *
     * @param ContractProduct $contractProduct
     * @param Price           $price
     *
     * @return Collection
     */
    public function handleOneTimeProduct(ContractProduct $contractProduct, Price $price)
    {
        $items = new Collection();

        $consume_rule = $price->consume_rule;
        $class_name = $consume_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\ConsumeRules\BaseConsumeRule) {
            if (intval($contractProduct->renewals) === 0) {
                $items->push(new Bag([
                    'price'            => $price,
                    'contract_product' => $contractProduct,
                    'value'            => $rule->calculate($consume_rule),
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
     * @param ContractProduct $contractProduct
     * @param Price           $price
     *
     * @return bool
     */
    public function shouldCreateFirstProductConsumed(ContractProduct $contractProduct, Price $price)
    {
        return true;
    }

    /**
     * Handle One Time Product.
     *
     * @param ContractProduct $contractProduct
     * @param Price           $price
     *
     * @return Collection
     */
    public function handleRecurringProduct(ContractProduct $contractProduct, Price $price)
    {
        $items = new Collection();

        $consume_rule = $price->consume_rule;
        $class_name = $consume_rule->class_name;
        $rule = new $class_name();

        // This product should be handled has one-time product. Bill immediately if the renewals is 0
        if ($rule instanceof \Railken\Amethyst\ConsumeRules\FrequencyConsumeRule) {
            // Retrieve last created_at for the same product;

            $cpm = new ContractProductConsumeManager();

            $last = $cpm->getRepository()->newQuery()->where([
                'product_id'  => $contractProduct->product->id,
                'contract_id' => $contractProduct->contract->id,
            ])->orderBy('created_at', 'DESC')->first();

            $value = null;

            if (!$last && $this->shouldCreateFirstProductConsumed($contractProduct, $price)) {
                $value = 1;
            } else {
                $payload = $consume_rule->payload;

                $start = $last->created_at;

                // We always want to consume products until the next cycle;
                $now = (new \DateTime());

                // We assume the consumer is always up, so if more than one cycle has passed we will make no adjustments.
                $diff = $start->diff($now);
                $cyclePassed = $rule->getDateIntervalPropertyByUnit($diff, $payload->frequency_unit) / $payload->frequency_value;

                // If the previous values was 0.80, we will wait only 0.80 time to consume again the recurrent product.
                if ($cyclePassed >= $last->value) {
                    $value = 1;
                }
            }

            if ($value) {
                $items->push(new Bag([
                    'price'            => $price,
                    'contract_product' => $contractProduct,
                    'value'            => $value,
                ]));
            }
        }

        return $items;
    }

    /**
     * @param ContractProduct $contractProduct
     *
     * @return array
     */
    public function getPricesByContractProduct(ContractProduct $contractProduct)
    {
        return $contractProduct->prices;
    }

    /**
     * @param ContractProduct $contractProduct
     *
     * @return InvoiceItem
     */
    public function createItem(ContractProduct $contractProduct)
    {
        $items = new Collection();

        foreach ($this->getPricesByContractProduct($contractProduct) as $price) {
            // OneTimeProduct should be added manually
            // $items = $items->merge($this->handleOneTimeProduct($contractProduct, $sellableProductCatalogue));
            $items = $items->merge($this->handleRecurringProduct($contractProduct, $price));
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
                $items = $items->merge($this->createItem($product));
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

        $items = $this->getItemsToConsume($contract);

        if ($items->count() > 0) {
            $cpm = new ContractProductConsumeManager();

            foreach ($items as $item) {
                $cpm->createOrFail([
                    'contract_id' => $contract->id,
                    'product_id'  => $item->get('contract_product')->product->id,
                    'price'       => $item->get('price')->price,
                    'tax_id'      => $contract->tax_id,
                    'group_id'    => $item->get('contract_product')->group->id,
                    'value'       => $item->get('value'),
                ]);
            }
        }

        return null;
    }
}
