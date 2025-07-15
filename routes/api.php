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

    Route::prefix('called')->group(function () {
        Route::get('/', [ChamadoController::class, 'index']);
        Route::get('/stats', [ChamadoController::class, 'stats']);
        Route::post('/create', [ChamadoController::class, 'store']);
        Route::get('/{id}', [ChamadoController::class, 'show']);
        Route::put('/{id}', [ChamadoController::class, 'update']);
        Route::delete('/{id}', [ChamadoController::class, 'destroy']);
        Route::post('/{id}/close', [ChamadoController::class, 'close']);
        Route::get('/{id}/responses', [RespostaController::class, 'getByChamado']);
        Route::post('response', [RespostaController::class, 'store']);

   });
   Route::put('users/{id}', [UserController::class, 'update']);
   Route::delete('users/{id}', [UserController::class, 'destroy']);
});



Route::get('users/{id}',[UserController::class,'show']);
Route::get('users', [UserController::class, 'index']);






Route::get('report', [ChamadoController::class, 'gerarPDF']);
Route::get('/{status}', [ChamadoController::class, 'filter']);


