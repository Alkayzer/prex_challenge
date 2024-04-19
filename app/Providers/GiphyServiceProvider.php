<?php

namespace App\Providers;

use App\Services\GiphyService;
use App\Services\LogService;
use Illuminate\Support\ServiceProvider;

class GiphyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GiphyService::class, function ($app) {
            return new GiphyService($app->make(LogService::class), config('services.giphy.api_key'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
