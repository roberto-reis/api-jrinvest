<?php

namespace App\Providers;

use App\Interfaces\ICotacaoBrapi;
use App\Services\Api\CotacaoBrapiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ICotacaoBrapi::class, CotacaoBrapiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
