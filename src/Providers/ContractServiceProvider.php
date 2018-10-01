<?php

namespace Railken\Amethyst\Providers;

use Railken\Amethyst\Common\CommonServiceProvider;

class ContractServiceProvider extends CommonServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        parent::register();

        $this->app->register(\Railken\Amethyst\Providers\AddressServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\TaxServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\RecurringServiceServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\CustomerServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\InvoiceServiceProvider::class);
    }
}
