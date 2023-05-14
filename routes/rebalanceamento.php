<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RebalanceamentoClasseController;

Route::controller(RebalanceamentoClasseController::class)
        ->prefix('rebalanceamento-classes')->name('rebalanceamento-classes')->group(function() {

    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('show/{uid}', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('update/{uid}', 'update')->name('.update');
    Route::delete('delete/{uid}', 'delete')->name('.delete');
});

