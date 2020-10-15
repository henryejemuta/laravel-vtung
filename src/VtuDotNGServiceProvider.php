<?php

namespace HenryEjemuta\LaravelVtuDotNG;

use HenryEjemuta\LaravelVtuDotNG\Console\InstallLaravelVtuDotNG;
use Illuminate\Support\ServiceProvider;

class VtuDotNGServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('vtung.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                InstallLaravelVtuDotNG::class,
            ]);

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'vtung');

        // Register the main class to use with the facade
        $this->app->singleton('vtung', function ($app) {
            $baseUrl = config('vtung.base_url');
            $instanceName = 'vtung';

            return new VtuDotNG(
                $baseUrl,
                $instanceName,
                config('vtung')
            );
        });

    }
}
