<?php

namespace Railken\LaraOre\Tests\Contract;

use Illuminate\Support\Facades\File;
use Railken\Bag;
use Railken\LaraOre\Address\AddressManager;
use Railken\LaraOre\Contract\ContractManager;
use Railken\LaraOre\Tax\TaxManager;
use Railken\LaraOre\LegalEntity\LegalEntityManager;
use Railken\LaraOre\Taxonomy\TaxonomyManager;
use Railken\LaraOre\Customer\CustomerManager;
use Railken\LaraOre\RecurringService\RecurringServiceManager;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\ContractServiceProvider::class,
        ];
    }

    /**
        * New LegalEntity
        *
        * @return \Railken\LaraOre\LegalEntity\LegalEntity
        */
    public function newLegalEntity()
    {
        $bag = new Bag();
        $bag->set('name', str_random(40));
        $bag->set('notes', str_random(40));
        $bag->set('country_iso', 'IT');
        $bag->set('vat_number', '203458239B01');
        $bag->set('code_vat', '203458239B01');
        $bag->set('code_tin', '203458239B01');
        $bag->set('code_it_rea', '123');
        $bag->set('code_it_sia', '123');
        $bag->set('registered_office_address_id', $this->newAddress()->id);
        
        $lem = new LegalEntityManager();

        return $lem->create($bag)->getResource();
    }

    /**
     * New address.
     *
     * @return \Railken\LaraOre\Address\Address
     */
    public function newAddress()
    {
        $am = new AddressManager();

        $bag = new Bag();
        $bag->set('name', 'El. psy. congroo.');
        $bag->set('street', str_random(40));
        $bag->set('zip_code', '00100');
        $bag->set('city', 'ROME');
        $bag->set('province', 'RM');
        $bag->set('country', 'IT');

        return $am->create($bag)->getResource();
    }

    /**
     * Retrieve correct Bag of parameters.
     *
     * @return Bag
     */
    public function newCustomer()
    {
        $cm = new CustomerManager();

        $bag = new Bag();
        $bag->set('name', str_random(40));
        $bag->set('notes', str_random(40));
        $bag->set('legal_entity_id', $this->newLegalEntity()->id);
        return $cm->create($bag)->getResource();
    }

    /**
     * Retrieve correct bag of parameters.
     *
     * @return Bag
     */
    public function getParameters()
    {
        $bag = new Bag();
        $bag->set('customer_id', $this->newCustomer()->id);
        $bag->set('price', 20);
        $bag->set('price_start', 20);
        $bag->set('price_end', 10);

        return $bag;
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/../..', '.env');
        $dotenv->load();

        parent::setUp();

        File::cleanDirectory(database_path('migrations/'));

        $this->artisan('migrate:fresh');
        $this->artisan('lara-ore:user:install');

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\ContractServiceProvider',
            '--force'    => 'true',
        ]);

        $this->artisan('migrate');
    }
}
