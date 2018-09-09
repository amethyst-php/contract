<?php

namespace Railken\LaraOre;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Console\Commands\ContractInstallCommand;

class ContractServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
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
     */
    public function register()
    {
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->register(\Railken\LaraOre\UserServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TaxonomyServiceProvider::class);
        $this->app->register(\Railken\LaraOre\LegalEntityServiceProvider::class);
        $this->app->register(\Railken\LaraOre\TaxServiceProvider::class);
        $this->app->register(\Railken\LaraOre\RecurringServiceServiceProvider::class);
        $this->app->register(\Railken\LaraOre\InvoiceServiceProvider::class);
        $this->app->register(\Railken\LaraOre\CustomerServiceProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../config/ore.contract.php', 'ore.contract');
        $this->mergeConfigFrom(__DIR__.'/../config/ore.contract-service.php', 'ore.contract-service');
    }

    /**
     * Load routes.
     */
    public function loadRoutes()
    {
        $config = Config::get('ore.contract.http.admin');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');

                $router->get('/', ['uses' => $controller.'@index']);
                $router->post('/', ['uses' => $controller.'@create']);
                $router->put('/{id}', ['uses' => $controller.'@update']);
                $router->delete('/{id}', ['uses' => $controller.'@remove']);
                $router->get('/{id}', ['uses' => $controller.'@show']);
            });
        }

        $config = Config::get('ore.contract-service.http.admin');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');

                $router->get('/', ['uses' => $controller.'@index']);
                $router->post('/', ['uses' => $controller.'@create']);
                $router->put('/{id}', ['uses' => $controller.'@update']);
                $router->delete('/{id}', ['uses' => $controller.'@remove']);
                $router->get('/{id}', ['uses' => $controller.'@show']);
            });
        }
    }
}
