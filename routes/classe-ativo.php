<?php

use App\Http\Controllers\ClasseAtivoController;
use Illuminate\Support\Facades\Route;


Route::controller(ClasseAtivoController::class)->prefix('classe-ativo')->group(function() {
    Route::get('list-all', 'listAll');
});

