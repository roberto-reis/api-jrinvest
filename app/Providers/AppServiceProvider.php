<?php

namespace App\Providers;

use App\Interfaces\ICotacaoBrapi;
use Illuminate\Support\Collection;
use App\Repositories\AuthRepository;
use App\Repositories\AtivoRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\Api\CotacaoBrapiService;
use App\Repositories\ClasseAtivoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\Repositories\IAuthRepository;
use App\Interfaces\Repositories\IAtivoRepository;
use App\Repositories\RebalanceamentoAtivoRepository;
use App\Repositories\RebalanceamentoClasseRepository;
use App\Interfaces\Repositories\IClasseAtivoRepository;
use App\Interfaces\Repositories\IOperacaoRepository;
use App\Interfaces\Repositories\IProventoRepository;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;
use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;
use App\Repositories\OperacaoRepository;
use App\Repositories\ProventoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(ICotacaoBrapi::class, CotacaoBrapiService::class);
        $this->app->singleton(IClasseAtivoRepository::class, ClasseAtivoRepository::class);
        $this->app->singleton(IAtivoRepository::class, AtivoRepository::class);
        $this->app->singleton(IRebalanceamentoClasseRepository::class, RebalanceamentoClasseRepository::class);
        $this->app->singleton(IAuthRepository::class, AuthRepository::class);
        $this->app->singleton(IRebalanceamentoAtivoRepository::class, RebalanceamentoAtivoRepository::class);
        $this->app->singleton(IProventoRepository::class, ProventoRepository::class);
        $this->app->singleton(IOperacaoRepository::class, OperacaoRepository::class);
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
