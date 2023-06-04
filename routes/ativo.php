<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtivoController;

Route::controller(AtivoController::class)->prefix('ativo')->name('ativos')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('{uid}/show', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('{uid}/update', 'update')->name('.update');
    Route::delete('{uid}/delete', 'delete')->name('.delete');
});

