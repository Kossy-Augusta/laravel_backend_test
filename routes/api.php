<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public Routes
Route::post('/register', [AuthController::class, 'register']);
