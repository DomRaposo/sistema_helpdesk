<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\RespostaController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('users', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('chamados')->group(function () {
        Route::get('/', [ChamadoController::class, 'index']);
        Route::get('/stats', [ChamadoController::class, 'stats']);
        Route::post('/criar', [ChamadoController::class, 'store']);
        Route::get('/{id}', [ChamadoController::class, 'show']);
        Route::put('/{id}', [ChamadoController::class, 'update']);
        Route::delete('/{id}', [ChamadoController::class, 'destroy']);

        Route::post('respostas', [RespostaController::class, 'store']);
   });
});



Route::get('users/{id}',[UserController::class,'show']);
Route::get('users', [UserController::class, 'index']);






Route::get('relatorio', [ChamadoController::class, 'gerarPDF']);
Route::get('/{status}', [ChamadoController::class, 'filter']);


