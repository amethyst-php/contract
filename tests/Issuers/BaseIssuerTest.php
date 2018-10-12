<?php

namespace Railken\Amethyst\Tests\Issuers;

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
use Railken\Amethyst\PriceRules\FrequencyPriceRule;
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

        // The price for the activation of the product
        // Indicate the price of the product we're selling
        $spcm = new SellableProductCatalogueManager();
        $product1ActivationService = $spcm->createOrFail(
            SellableProductCatalogueFaker::make()->parameters()
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
                ->set('price_rule.class_name', BasePriceRule::class)
                ->set('price', 80.00)
                ->remove('target')->set('target_id', $target->id)
        )->getResource();

        // The price for the subscription of the product
        // Indicate the price of the product we're selling
        $product1BilledMonthly = $spcm->createOrFail(
            SellableProductCatalogueFaker::make()->parameters()
                ->remove('catalogue')->set('catalogue_id', $catalogue->id)
                ->remove('product')->set('product_id', $product->id)
                ->set('price_rule.class_name', FrequencyPriceRule::class)
                ->set('price_rule.payload', [
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

        $issuer = new BaseIssuer();

        $items = $issuer->getItemsToIssue($target, $contract);
        $this->assertEquals(2, $items->count());
        $this->assertEquals(80.00, $items->get(0)->get('price'));
        $this->assertEquals(20, $items->get(1)->get('price'));

        // Change starts_at to make it 75 days
        // This way well'get a 15 OneTime + 60 subscription
        $contractProduct->starts_at = (new \DateTime())->modify('-2 month')->modify('-15 days');
        $contractProduct->save();
        $contract = $cm->getRepository()->findOneById($contract->id);

        $items = $issuer->getItemsToIssue($target, $contract);
        $this->assertEquals(2, $items->count());
        $this->assertEquals(80.00, $items->get(0)->get('price'));
        $this->assertEquals(40, $items->get(1)->get('price'));

        // Change frequency_value to 2
        $price_rule = $product1BilledMonthly->price_rule;
        $price_rule->payload = [
            'frequency_value' => 2,
            'frequency_unit'  => 'months',
        ];
        $price_rule->save();
        $contract = $cm->getRepository()->findOneById($contract->id);

        $items = $issuer->getItemsToIssue($target, $contract);
        $this->assertEquals(2, $items->count());
        $this->assertEquals(80.00, $items->get(0)->get('price'));
        $this->assertEquals(20, $items->get(1)->get('price'));

        $sender = (new LegalEntityManager())->createOrFail(LegalEntityFaker::make()->parameters())->getResource();
        $invoice = $issuer->issue($sender, $target, $contract);
        $this->assertEquals(2, $invoice->items->count());
    }
}
