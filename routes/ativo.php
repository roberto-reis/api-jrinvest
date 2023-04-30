<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtivoController;

Route::controller(AtivoController::class)->prefix('ativo')->name('ativo')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
    Route::post('store', 'store')->name('.store');
    Route::put('update/{uid}', 'update')->name('.update');
});

