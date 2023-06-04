<?php

use App\Http\Controllers\ProventoController;
use Illuminate\Support\Facades\Route;

Route::controller(ProventoController::class)->prefix('proventos')->name('proventos')->group(function() {
    Route::get('list-all/{userUid}', 'listAll')->name('.listAll');
    Route::get('show/{uid}', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('update/{uid}', 'update')->name('.update');
    Route::delete('delete/{uid}', 'delete')->name('.delete');
});

