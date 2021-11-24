<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Contracts\DirectoryInterface;
use App\Lib\Directory;

class DirectoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DirectoryInterface::class, function($app) {
            return new Directory();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
