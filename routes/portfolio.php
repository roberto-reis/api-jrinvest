<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::controller(PortfolioController::class)->prefix('portfolio')->name('portfolio')->group(function() {
    Route::get('listar', 'listar')->name('.listar');
    Route::get('posicaoAtual', 'posicaoAtual')->name('.posicaoAtual');
    Route::get('posicaoIdeal', 'posicaoIdeal')->name('.posicaoIdeal');
    Route::get('posicaoAjuste', 'posicaoAjuste')->name('.posicaoAjuste');

    Route::get('posicaoAtualPorClasse', 'posicaoAtualPorClasse')->name('.posicaoAtualPorClasse');
    Route::get('posicaoIdealPorClasse', 'posicaoIdealPorClasse')->name('.posicaoIdealPorClasse');
});

