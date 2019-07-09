<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Illuminate\Support\Facades\Config;
use Railken\Bag;
use Railken\Lem\Faker;

class ContractFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('code', str_random(10));
        $bag->set('notes', str_random(40));
        $bag->set('customer', CustomerFaker::make()->parameters()->toArray());
        $bag->set('target', TargetFaker::make()->parameters()->toArray());
        $bag->set('tax', TaxFaker::make()->parameters()->toArray());
        $bag->set('country', 'IT');
        $bag->set('locale', 'it_IT');
        $bag->set('currency', 'EUR');
        $bag->set('group', TaxonomyFaker::make()->parameters()->toArray());
        $bag->set('group.parent.name', Config::get('amethyst.contract.data.contract.attributes.payment_method.parent'));

        return $bag;
    }
}
