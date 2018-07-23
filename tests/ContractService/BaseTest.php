<?php

namespace Railken\LaraOre\Tests\ContractService;

use Illuminate\Support\Facades\File;
use Railken\Bag;
use Railken\LaraOre\Address\AddressManager;
use Railken\LaraOre\Contract\ContractManager;
use Railken\LaraOre\Customer\CustomerManager;
use Railken\LaraOre\LegalEntity\LegalEntityManager;
use Railken\LaraOre\RecurringService\RecurringServiceManager;
use Railken\LaraOre\Tax\TaxManager;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
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

    /**
     * New LegalEntity.
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
     * @return \Railken\LaraOre\Tax\Tax
     */
    public function newTax()
    {
        $am = new TaxManager();

        $bag = new Bag();
        $bag->set('name', 'Vat 22%');
        $bag->set('description', 'Give me');
        $bag->set('calculator', 'x*0.22');

        return $am->findOrCreate($bag->toArray())->getResource();
    }

    /**
     * @return \Railken\LaraOre\RecurringService\RecurringService
     */
    public function newService()
    {
        $m = new RecurringServiceManager();

        $bag = new Bag();
        $bag->set('name', str_random(40));
        $bag->set('code', str_random(40));
        $bag->set('description', str_random(40));
        $bag->set('notes', str_random(40));
        $bag->set('country', 'IT');
        $bag->set('locale', 'it_IT');
        $bag->set('enabled', true);
        $bag->set('price_starting', 40);
        $bag->set('price', 10);
        $bag->set('price_ending', 10);
        $bag->set('currency', 'EUR');
        $bag->set('tax_id', $this->newTax()->id);
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);

        return $m->create($bag->toArray())->getResource();
    }

    /**
     * Retrieve correct bag of parameters.
     *
     * @return \Railken\LaraOre\Contract\Contract
     */
    public function newContract()
    {
        $am = new ContractManager();

        $bag = new Bag();
        $bag->set('code', str_random(10));
        $bag->set('notes', str_random(40));
        $bag->set('customer_id', $this->newCustomer()->id);
        $bag->set('tax_id', $this->newTax()->id);
        $bag->set('country', 'IT');
        $bag->set('locale', 'it_IT');
        $bag->set('currency', 'EUR');
        $bag->set('payment_method', 'iban');
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);
        $bag->set('renewals', 0);
        $bag->set('starts_at', '2018-01-01');
        $bag->set('ends_at', '2018-01-01');
        $bag->set('last_bill_at', '2018-01-01');
        $bag->set('next_bill_at', '2018-01-01');

        return $am->create($bag->toArray())->getResource();
    }

    /**
     * Retrieve correct bag of parameters.
     *
     * @return Bag
     */
    public function getParameters()
    {
        $bag = new Bag();
        $bag->set('code', str_random(10));
        $bag->set('contract_id', $this->newContract()->id);
        $bag->set('tax_id', $this->newTax()->id);
        $bag->set('address_id', $this->newAddress()->id);
        $bag->set('service_id', $this->newService()->id);
        $bag->set('price', 20);
        $bag->set('price_start', 20);
        $bag->set('price_end', 10);
        $bag->set('frequency_unit', 'days');
        $bag->set('frequency_value', 10);
        $bag->set('renewals', 0);

        return $bag;
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\ContractServiceProvider::class,
        ];
    }
}
