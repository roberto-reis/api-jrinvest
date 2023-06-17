<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1/')->group(function() {
    Route::middleware('auth:sanctum')->group(function() {
        require __DIR__ . '/classe-ativo.php';
        require __DIR__ . '/ativo.php';
        require __DIR__ . '/rebalanceamento.php';
        require __DIR__ . '/provento.php';
        require __DIR__ . '/operacao.php';
    });

    require __DIR__ . '/auth.php';
});

