<?php

namespace Railken\Amethyst\Tests;

use Illuminate\Support\Facades\File;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected static $setup = false;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        if (static::$setup === true) {
            return true;
        }

        static::$setup = true;

        File::cleanDirectory(database_path('migrations/'));

        $this->artisan('vendor:publish', [
            '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
        ]);

        $this->artisan('migrate:fresh');
        $this->artisan('amethyst:invoice:install');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\Amethyst\Providers\ContractServiceProvider::class,
        ];
    }
}
