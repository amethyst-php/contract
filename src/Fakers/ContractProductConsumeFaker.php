<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Illuminate\Support\Facades\Config;
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
        $bag->set('contract', ContractFaker::make()->parameters()->toArray());
        $bag->set('product', ProductFaker::make()->parameters()->toArray());
        $bag->set('tax', TaxFaker::make()->parameters()->toArray());
        $bag->set('group', TaxonomyFaker::make()->parameters()->toArray());
        $bag->set('group.parent.name', Config::get('amethyst.contract.data.contract-product.group-taxonomy'));
        $bag->set('price', 10);
        $bag->set('value', 1);
        $bag->set('notes', $faker->text);

        return $bag;
    }
}
