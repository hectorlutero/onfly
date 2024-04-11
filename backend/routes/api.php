<?php

use App\Http\Controllers\API\Admin\ExpenseController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);;
Route::post('/register', [AuthController::class, 'register']);
Route::get('/profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);

Route::apiResource('expenses', ExpenseController::class)->middleware(['auth:sanctum']);
