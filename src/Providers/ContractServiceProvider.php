<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Api\Support\Router;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Managers\ContractProductManager;
use Railken\Amethyst\Models\ContractProduct;

class ContractServiceProvider extends CommonServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        parent::register();
        $this->loadExtraRoutes();

        $this->app->register(\Railken\Amethyst\Providers\AddressServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\TaxServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\ProductServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\CustomerServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\InvoiceServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\TaxonomyServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\PriceServiceProvider::class);

        Config::set('amethyst.price.data.price.attributes.priceable.options.'.ContractProduct::class, ContractProductManager::class);
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
