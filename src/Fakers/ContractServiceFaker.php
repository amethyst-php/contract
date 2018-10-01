<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class ContractServiceFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('code', str_random(10));
        $bag->set('contract', ContractFaker::make()->parameters()->toArray());
        $bag->set('tax', TaxFaker::make()->parameters()->toArray());
        $bag->set('address', AddressFaker::make()->parameters()->toArray());
        $bag->set('service', RecurringServiceFaker::make()->parameters()->toArray());
        $bag->set('customer', CustomerFaker::make()->parameters()->toArray());
        $bag->set('price', 20);
        $bag->set('price_start', 20);
        $bag->set('price_end', 10);
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);
        $bag->set('renewals', 0);

        return $bag;
    }
}
