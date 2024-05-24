<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/products', [ProductController::class, 'store']);
});