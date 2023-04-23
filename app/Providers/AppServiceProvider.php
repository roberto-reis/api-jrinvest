<?php

namespace App\Providers;

use App\Interfaces\ICotacaoBrapi;
use App\Repositories\AtivoRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\Api\CotacaoBrapiService;
use App\Repositories\ClasseAtivoRepository;
use App\Interfaces\Repositories\IAtivoRepository;
use App\Interfaces\Repositories\IClasseAtivoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ICotacaoBrapi::class, CotacaoBrapiService::class);
        $this->app->singleton(IClasseAtivoRepository::class, ClasseAtivoRepository::class);
        $this->app->singleton(IAtivoRepository::class, AtivoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
