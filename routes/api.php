<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Suas rotas protegidas aqui
});
Route::get('users/{id}',[UserController::class,'show']);
Route::post('users', [UserController::class, 'store']);
