<?php

namespace App\Providers;

use App\Interfaces\ICotacaoBrapi;
use Illuminate\Support\Collection;
use App\Repositories\AtivoRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\Api\CotacaoBrapiService;
use App\Repositories\ClasseAtivoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
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
         /**
         * Paginate a standard Laravel Collection.
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
