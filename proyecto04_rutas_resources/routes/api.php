<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// 1. Ruta pública para el login (Punto 7 de los apuntes)

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Grupo de rutas protegidas con Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('products', ProductController::class);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
