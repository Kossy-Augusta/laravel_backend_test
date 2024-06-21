<?php

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RolesAndPermissionController;

// public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetEmailLink'])->name('password.email');
Route::post('/password-reset', [ResetPasswordController::class,'reset'])->name('password.reset');
// Protected routes
Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}/update', [ProductController::class, 'update']);
    Route::delete('/products/{id}/destroy', [ProductController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', CheckAdmin::class])->group(function(){
    Route::post('/category', [CategoryController::class, 'store']);
    Route::put('/category/{id}/update', [CategoryController::class, 'update']);
    Route::delete('/category/{id}/destroy', [CategoryController::class, 'destroy']);
});