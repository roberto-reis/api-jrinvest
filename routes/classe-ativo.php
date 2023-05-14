<?php

use App\Http\Controllers\ClasseAtivoController;
use Illuminate\Support\Facades\Route;

Route::controller(ClasseAtivoController::class)->prefix('classe-ativo')->name('classe-ativo')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('show/{uid}', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('update/{uid}', 'update')->name('.update');
    Route::delete('delete/{uid}', 'delete')->name('.delete');
});

