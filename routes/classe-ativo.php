<?php

use App\Http\Controllers\ClasseAtivoController;
use Illuminate\Support\Facades\Route;

Route::controller(ClasseAtivoController::class)->prefix('classe-ativo')->name('classe-ativo')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
    Route::get('{uid}/show', 'show')->name('.show');
    Route::post('store', 'store')->name('.store');
    Route::put('{uid}/update', 'update')->name('.update');
    Route::delete('{uid}/delete', 'delete')->name('.delete');
});

