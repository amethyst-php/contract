<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class ContractProductConsumeFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('contract_product', ContractProductFaker::make()->parameters()->toArray());
        $bag->set('sellable_product', SellableProductCatalogueFaker::make()->parameters()->toArray());
        $bag->set('value', 1);
        $bag->set('notes', $faker->text);
        $bag->set('billed_at', (new \DateTime()));

        return $bag;
    }
}
