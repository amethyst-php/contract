<?php

namespace Railken\LaraOre\Tests\Contract;

use Illuminate\Support\Facades\File;

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

        $this->artisan('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\ContractServiceProvider::class,
        ];
    }
}
