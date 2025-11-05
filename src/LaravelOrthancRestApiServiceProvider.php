<?php

namespace Plokko\LaravelOrthancRestApi;

use Illuminate\Support\ServiceProvider;

class LaravelOrthancRestApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //-- Publish config file --//
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('laravel-orthanc-restapi.php'),
        ], 'config');
        /*//--- Console commands ---///
        if ($this->app->runningInConsole())
        {
            $this->commands([
                GenerateCommand::class,
            ]);
        }
        */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge default config ///
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'laravel-orthanc-restapi'
        );
        // Facade accessor
        $this->app->bind(OrthancApiAccessor::class, function ($app) {
            return new OrthancApiAccessor($app->config->get('laravel-orthanc-restapi', []));
        });
    }

    public function provides()
    {
        return [
            OrthancApiAccessor::class,
        ];
    }
}
