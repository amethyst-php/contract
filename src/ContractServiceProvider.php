<?php

namespace Railken\LaraOre;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Console\Commands\ContractInstallCommand;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([
            __DIR__.'/../config/ore.contract.php' => config_path('ore.contract.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../config/ore.contract-service.php' => config_path('ore.contract-service.php'),
        ], 'config');

        // $this->commands([ContractInstallCommand::class]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutes();

        config(['ore.permission.managers' => array_merge(Config::get('ore.permission.managers', []), [
            \Railken\LaraOre\Contract\ContractManager::class,
            \Railken\LaraOre\ContractService\ContractServiceManager::class,
        ])]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->register(\Railken\LaraOre\UserServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TaxonomyServiceProvider::class);
        $this->app->register(\Railken\LaraOre\LegalEntityServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ListenerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TaxServiceProvider::class);
        $this->app->register(\Railken\LaraOre\RecurringServiceServiceProvider::class);
        $this->app->register(\Railken\LaraOre\CustomerServiceProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../config/ore.contract.php', 'ore.contract');
        $this->mergeConfigFrom(__DIR__.'/../config/ore.contract-service.php', 'ore.contract-service');
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Router::group(array_merge(Config::get('ore.contract.router'), [
            'namespace' => 'Railken\LaraOre\Http\Controllers',
        ]), function ($router) {
            $router->get('/', ['uses' => 'ContractsController@index']);
            $router->post('/', ['uses' => 'ContractsController@create']);
            $router->put('/{id}', ['uses' => 'ContractsController@update']);
            $router->delete('/{id}', ['uses' => 'ContractsController@remove']);
            $router->get('/{id}', ['uses' => 'ContractsController@show']);
        });

        Router::group(array_merge(Config::get('ore.contract-service.router'), [
            'namespace' => 'Railken\LaraOre\Http\Controllers',
        ]), function ($router) {
            $router->get('/', ['uses' => 'ContractServicesController@index']);
            $router->post('/', ['uses' => 'ContractServicesController@create']);
            $router->put('/{id}', ['uses' => 'ContractServicesController@update']);
            $router->delete('/{id}', ['uses' => 'ContractServicesController@remove']);
            $router->get('/{id}', ['uses' => 'ContractServicesController@show']);
        });
    }
}
