<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class ContractProductFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('contract', ContractFaker::make()->parameters()->toArray());
        $bag->set('sellable_product_catalogue', SellableProductCatalogueFaker::make()->parameters()->toArray());

        return $bag;
    }
}
