<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController; 
use Illuminate\Support\Facades\Route;

// Rotas de autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    
    // Rotas do carrinho
    Route::post('/cart/add', [CartController::class, 'store']); 
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy']); 
    Route::put('/cart/update/{id}', [CartController::class, 'update']); 
    Route::get('/cart', [CartController::class, 'index']); 
    Route::post('/cart/checkout', [CartController::class, 'checkout']); 
});
