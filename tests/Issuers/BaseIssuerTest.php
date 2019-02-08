<?php

namespace Railken\Amethyst\Tests\Issuers;

use Railken\Amethyst\Consumers\BaseConsumer;
use Railken\Amethyst\ConsumeRules\FrequencyConsumeRule;
use Railken\Amethyst\Fakers\CatalogueFaker;
use Railken\Amethyst\Fakers\CatalogueProductFaker;
use Railken\Amethyst\Fakers\ContractFaker;
use Railken\Amethyst\Fakers\ContractProductFaker;
use Railken\Amethyst\Fakers\LegalEntityFaker;
use Railken\Amethyst\Fakers\ProductFaker;
use Railken\Amethyst\Fakers\TargetFaker;
use Railken\Amethyst\Issuer\BaseIssuer;
use Railken\Amethyst\Managers\CatalogueManager;
use Railken\Amethyst\Managers\CatalogueProductManager;
use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Managers\ContractProductManager;
use Railken\Amethyst\Managers\LegalEntityManager;
use Railken\Amethyst\Managers\PriceManager;
use Railken\Amethyst\Managers\ProductManager;
use Railken\Amethyst\Managers\TargetManager;
use Railken\Amethyst\Models\ContractProduct;
use Railken\Amethyst\PriceRules\BasePriceRule;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Bag;

class BaseIssuerTest extends BaseTest
{
    /**
     * Test issuer.
     */
    public function testIssueContractSimpleProduct()
    {
        // Create a new catalogue
        // Indicate the group of products which we're selling
        $cm = new CatalogueManager();
        $catalogue = $cm->createOrFail(CatalogueFaker::make()->parameters())->getResource();

        // Create a new product
        // Indicate what we're selling
        $pm = new ProductManager();
        $product = $pm->createOrFail(
            ProductFaker::make()->parameters()
                ->set('name', 'Subscription Lite')
                ->set('type.name', 'subscriptions')
        )->getResource();

        // Create a new target
        // Indicate to who we're selling
        $tm = new TargetManager();
        $target = $tm->createOrFail(
            TargetFaker::make()->parameters()
                ->set('name', 'Customers')
        )->getResource();

        // Indicate the price of the product we're selling
        $priceManager = new PriceManager();

        // Indicate the price of the product we're selling
        $spcm = new CatalogueProductManager();

        $product1BilledMonthly = $spcm->createOrFail(
            CatalogueProductFaker::make()->parameters()
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
        )->getResource();

        // Now that we're all sets, we can create a new contract
        // Create a new fresh contract
        $cm = new ContractManager();
        $contract = $cm->createOrFail(
            ContractFaker::make()->parameters()
                ->set('renewals', 0)
                ->remove('target')->set('target_id', $target->id)
        )->getResource();

        // Add the product to the contract
        $cpm = new ContractProductManager();
        $contractProduct = $cpm->createOrFail(
            ContractProductFaker::make()->parameters()
                ->set('renewals', 0)
                ->remove('contract')->set('contract_id', $contract->id)
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
        )->getResource();

        $price = $priceManager->createOrFail(
            (new Bag())
                ->set('price_rule.name', 'Rule Name')
                ->set('price_rule.class_name', BasePriceRule::class)
                ->set('consume_rule.name', 'Rule Name')
                ->set('consume_rule.class_name', FrequencyConsumeRule::class)
                ->set('consume_rule.payload', [
                    'frequency_unit'  => 'months',
                    'frequency_value' => '1',
                ])
                ->set('price', 20)
                ->set('priceable_type', ContractProduct::class)
                ->set('priceable_id', $contractProduct->id)
                ->set('target_id', $target->id)
        )->getResource();

        // Refresh relations
        $contract = $cm->getRepository()->findOneById($contract->id);

        $consumer = new BaseConsumer();

        // Attiva in data x
        // Sospendi in data x
        // Riattiva in data x
        // Disattiva in data x

        // Only one item should be consumed (the recurring one)

        // Start contract and relative products
        $cm->start($contract);
        $cpm->start($contract->products[0]);

        $items = $consumer->getItemsToConsume($contract);

        $this->assertEquals(1, $items->count());
        $this->assertEquals(1, $items->get(0)->get('value'));

        $consumer->consume($contract);

        $issuer = new BaseIssuer();

        $items = $issuer->getItemsToIssue($contract);

        $sender = (new LegalEntityManager())->createOrFail(LegalEntityFaker::make()->parameters())->getResource();
        $invoice = $issuer->issue($sender, $contract);
        $this->assertEquals(1, $invoice->items->count());
    }
}
