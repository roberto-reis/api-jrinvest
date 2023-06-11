<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RebalanceamentoAtivoController;
use App\Http\Controllers\RebalanceamentoClasseController;

Route::controller(RebalanceamentoClasseController::class)
        ->prefix('rebalanceamento-classes')->name('rebalanceamento-classes')->group(function() {

    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('{uid}/show', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('{uid}/update', 'update')->name('.update');
    Route::delete('{uid}/delete', 'delete')->name('.delete');
});

Route::controller(RebalanceamentoAtivoController::class)
        ->prefix('rebalanceamento-ativos')->name('rebalanceamento-ativos')->group(function() {

    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('{uid}/show', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('{uid}/update', 'update')->name('.update');
    Route::delete('{uid}/delete', 'delete')->name('.delete');
});

