<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
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
        $bag->set('address', AddressFaker::make()->parameters()->toArray());
        $bag->set('tax', TaxFaker::make()->parameters()->toArray());
        $bag->set('country', 'IT');
        $bag->set('locale', 'it_IT');
        $bag->set('currency', 'EUR');
        $bag->set('payment_method', 'iban');
        $bag->set('renewals', 12);
        $bag->set('starts_at', (new \DateTime())->modify('-1 year')->format('Y-m-d'));
        $bag->set('ends_at', (new \DateTime())->modify('+1 year')->format('Y-m-d'));
        $bag->set('last_bill_at', (new \DateTime())->modify('-1 month')->format('Y-m-d'));
        $bag->set('next_bill_at', (new \DateTime())->format('Y-m-d'));

        return $bag;
    }
}
