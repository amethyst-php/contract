<?php

namespace Amethyst\Providers;

use Amethyst\Api\Support\Router;
use Amethyst\Common\CommonServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class ContractServiceProvider extends CommonServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        parent::register();
        $this->loadExtraRoutes();

        $this->app->register(\Amethyst\Providers\AddressServiceProvider::class);
        $this->app->register(\Amethyst\Providers\TaxServiceProvider::class);
        $this->app->register(\Amethyst\Providers\ProductServiceProvider::class);
        $this->app->register(\Amethyst\Providers\CustomerServiceProvider::class);
        $this->app->register(\Amethyst\Providers\InvoiceServiceProvider::class);
        $this->app->register(\Amethyst\Providers\TaxonomyServiceProvider::class);
        $this->app->register(\Amethyst\Providers\PriceServiceProvider::class);
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        app('amethyst')->pushMorphRelation('price', 'priceable', 'contract-product');
    }

    /**
     * Load extras routes.
     */
    public function loadExtraRoutes()
    {
        $config = Config::get('amethyst.contract.http.admin.contract');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');
                $router->post('/{id}/start', ['as' => 'start', 'uses' => $controller.'@start']);
                $router->post('/{id}/suspend', ['as' => 'suspend', 'uses' => $controller.'@suspend']);
                $router->post('/{id}/resume', ['as' => 'resume', 'uses' => $controller.'@resume']);
                $router->post('/{id}/terminate', ['as' => 'terminate', 'uses' => $controller.'@terminate']);
            });
        }

        $config = Config::get('amethyst.contract.http.admin.contract-product');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');
                $router->post('/{id}/start', ['as' => 'start', 'uses' => $controller.'@start']);
                $router->post('/{id}/suspend', ['as' => 'suspend', 'uses' => $controller.'@suspend']);
                $router->post('/{id}/resume', ['as' => 'resume', 'uses' => $controller.'@resume']);
                $router->post('/{id}/terminate', ['as' => 'terminate', 'uses' => $controller.'@terminate']);
            });
        }
    }
}
