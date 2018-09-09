<?php

namespace Railken\LaraOre\Contract;

use Faker\Factory;
use Railken\Bag;
use Railken\LaraOre\Customer\CustomerFaker;
use Railken\LaraOre\Tax\TaxFaker;
use Railken\Laravel\Manager\BaseFaker;

class ContractFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = ContractManager::class;

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
        $bag->set('tax', TaxFaker::make()->parameters()->toArray());
        $bag->set('country', 'IT');
        $bag->set('locale', 'it_IT');
        $bag->set('currency', 'EUR');
        $bag->set('payment_method', 'iban');
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);
        $bag->set('renewals', 0);
        $bag->set('starts_at', '2018-01-01 00:00:00');
        $bag->set('ends_at', '2018-01-01 00:00:00');
        $bag->set('last_bill_at', '2018-01-01 00:00:00');
        $bag->set('next_bill_at', '2018-01-01 00:00:00');

        return $bag;
    }
}
