<?php

use App\Http\Controllers\API\Admin\ExpenseController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/users', [AuthController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);

// Route::apiResource('expenses', ExpenseController::class)->middleware(['auth:sanctum']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show']);
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);
});
