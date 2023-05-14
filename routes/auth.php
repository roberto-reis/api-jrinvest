<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->name('auth')->group(function() {
    Route::post('login', 'login')->name('.login');
    Route::post('logout', 'logout')->name('.logout');
    Route::post('register', 'register')->name('.register');
    Route::get('show/{uid}', 'show')->name('.show');
    Route::put('update/{uid}', 'update')->name('.update');
    Route::delete('delete/{uid}', 'delete')->name('.delete');
});
