<?php

namespace Mawuekom\DataRepository;

use Illuminate\Support\ServiceProvider;

class DataRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'data-repository');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'data-repository');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                //__DIR__.'/../config/config.php' => config_path('data-repository.php'),
                base_path('vendor/spatie/laravel-query-builder/config/query-builder.php') =>config_path('query-builder.php'),
                base_path('vendor/spatie/laravel-json-api-paginate/config/json-api-paginate.php') =>config_path('json-api-paginate.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/data-repository'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/data-repository'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/data-repository'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'data-repository');

        // Register the main class to use with the facade
        $this->app->singleton('data-repository', function () {
            return new DataRepository;
        });

        $this ->app ->register('Mawuekom\MacroSearch\MacroSearchServiceProvider');
        $this ->app ->register('Spatie\QueryBuilder\QueryBuilderServiceProvider');
        $this ->app ->register('Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider');
    }
}
