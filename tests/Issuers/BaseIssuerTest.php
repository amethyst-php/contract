<?php

namespace Railken\Amethyst\Tests\Issuers;

use Railken\Amethyst\Consumers\BaseConsumer;
use Railken\Amethyst\ConsumeRules\BaseConsumeRule;
use Railken\Amethyst\ConsumeRules\FrequencyConsumeRule;
use Railken\Amethyst\Fakers\CatalogueFaker;
use Railken\Amethyst\Fakers\ContractFaker;
use Railken\Amethyst\Fakers\ContractProductFaker;
use Railken\Amethyst\Fakers\LegalEntityFaker;
use Railken\Amethyst\Fakers\ProductFaker;
use Railken\Amethyst\Fakers\SellableProductCatalogueFaker;
use Railken\Amethyst\Fakers\TargetFaker;
use Railken\Amethyst\Issuer\BaseIssuer;
use Railken\Amethyst\Managers\CatalogueManager;
use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Managers\ContractProductManager;
use Railken\Amethyst\Managers\LegalEntityManager;
use Railken\Amethyst\Managers\ProductManager;
use Railken\Amethyst\Managers\SellableProductCatalogueManager;
use Railken\Amethyst\Managers\TargetManager;
use Railken\Amethyst\PriceRules\BasePriceRule;
use Railken\Amethyst\Tests\BaseTest;

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
        $spcm = new SellableProductCatalogueManager();

        // The price for the subscription of the product
        // Indicate the price of the product we're selling
        $product1BilledMonthly = $spcm->createOrFail(
            SellableProductCatalogueFaker::make()->parameters()
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
                ->set('price_rule.class_name', BasePriceRule::class)
                ->set('consume_rule.class_name', FrequencyConsumeRule::class)
                ->set('consume_rule.payload', [
                    'frequency_unit'  => 'months',
                    'frequency_value' => '1',
                ])
                ->set('price', 20)
                ->remove('target')->set('target_id', $target->id)
        )->getResource();

        // Now that we're all sets, we can create a new contract
        // Create a new fresh contract
        $cm = new ContractManager();
        $contract = $cm->createOrFail(
            ContractFaker::make()->parameters()
                ->set('renewals', 0)
                ->set('starts_at', (new \DateTime())->modify('-1 month'))
                ->set('ends_at', null)
                ->set('last_bill_at', null)
                ->set('next_bill_at', null)
        )->getResource();

        // Add the product to the contract
        $cpm = new ContractProductManager();
        $contractProduct = $cpm->createOrFail(
            ContractProductFaker::make()->parameters()
                ->set('renewals', 0)
                ->remove('contract')->set('contract_id', $contract->id)
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
                ->set('starts_at', (new \DateTime())->modify('-1 month'))
                ->set('ends_at', null)
                ->set('last_bill_at', null)
                ->set('next_bill_at', null)
        )->getResource();

        // Refresh relations
        $contract = $cm->getRepository()->findOneById($contract->id);

        $consumer = new BaseConsumer();


        // Attiva in data x
        // Sospendi in data x
        // Riattiva in data x
        // Disattiva in data x

        // Only one item should be consumed (the recurring one)
        $items = $consumer->getItemsToConsume($target, $contract);

        $this->assertEquals(1, $items->count());
        $this->assertEquals(1, $items->get(0)->get('value'));

        $consumer->consume($target, $contract);

        /*$issuer = new BaseIssuer();

        $items = $issuer->getItemsToIssue($target, $contract)

        $this->assertEquals(80.00, $items->get(0)->get('price'));
        $this->assertEquals(20, $items->get(1)->get('price'));

        $sender = (new LegalEntityManager())->createOrFail(LegalEntityFaker::make()->parameters())->getResource();
        $invoice = $issuer->issue($sender, $target, $contract);
        $this->assertEquals(2, $invoice->items->count());
        */
    }
}
