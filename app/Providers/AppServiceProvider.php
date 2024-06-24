<?php

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastServiceProvider;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        // Register the BroadcastServiceProvider
        $this->app->register(BroadcastServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }
}
