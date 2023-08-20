<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::controller(PortfolioController::class)->prefix('portfolio')->name('portfolio')->group(function() {
    Route::get('list-all', 'listAll')->name('.listAll');
});

