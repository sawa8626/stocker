<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CreateItemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'CreateItemService',
            'App\Services\CreateItemService'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
