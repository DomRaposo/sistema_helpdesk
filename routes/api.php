<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\ChamadoController;

//Rotas Users
Route::post('/login', [AuthController::class, 'login']);
Route::post('users', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

});
Route::get('users/{id}',[UserController::class,'show']);

//Rotas chamados
Route::apiResource('chamados', ChamadoController::class);
Route::get('chamados-stats', [ChamadoController::class, 'stats']);

