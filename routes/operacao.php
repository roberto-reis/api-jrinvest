<?php

use App\Http\Controllers\OperacaoController;
use Illuminate\Support\Facades\Route;

Route::controller(OperacaoController::class)->prefix('operacoes')->name('operacoes')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('{uid}/show', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('{uid}/update', 'update')->name('.update');
    Route::delete('{uid}/delete', 'delete')->name('.delete');
});

