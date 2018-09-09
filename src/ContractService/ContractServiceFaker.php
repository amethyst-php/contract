<?php

namespace Railken\LaraOre\ContractService;

use Faker\Factory;
use Railken\Bag;
use Railken\LaraOre\Address\AddressFaker;
use Railken\LaraOre\Contract\ContractFaker;
use Railken\LaraOre\RecurringService\RecurringServiceFaker;
use Railken\LaraOre\Tax\TaxFaker;
use Railken\Laravel\Manager\BaseFaker;

class ContractServiceFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = ContractServiceManager::class;

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
        $bag->set('price', 20);
        $bag->set('price_start', 20);
        $bag->set('price_end', 10);
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);
        $bag->set('renewals', 0);

        return $bag;
    }
}
