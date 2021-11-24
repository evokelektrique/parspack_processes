<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Contracts\ProcessInterface;
use App\Lib\Process;

class ProcessesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProcessInterface::class, function($app) {
            return new Process();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
