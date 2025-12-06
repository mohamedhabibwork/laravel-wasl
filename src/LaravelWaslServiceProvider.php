<?php

namespace Habib\LaravelWasl;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelWaslServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wasl')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(WaslClient::class);
        $this->app->singleton(LaravelWasl::class, function ($app) {
            return new LaravelWasl($app->make(WaslClient::class));
        });
    }
}
