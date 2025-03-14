<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GastoController; 
use App\Http\Controllers\AuthController;  

// Rutas API protegidas por middleware
Route::middleware('auth:api')->group(function () {
    Route::get('/gastos', [GastoController::class, 'index']);
    Route::post('/gastos', [GastoController::class, 'store']);
    Route::put('/gastos/{gasto}', [GastoController::class, 'update']);
    Route::delete('/gastos/{gasto}', [GastoController::class, 'destroy']);
});

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
