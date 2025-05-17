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


Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados.index');
Route::post('chamados', [ChamadoController::class, 'store'])->name('chamados.store');
Route::get('chamados/{id}', [ChamadoController::class, 'show'])->name('chamados.show');
Route::put('chamados/{id}', [ChamadoController::class, 'update'])->name('chamados.update');
Route::delete('chamados/{id}', [ChamadoController::class, 'destroy'])->name('chamados.destroy');
Route::get('chamados-stats', [ChamadoController::class, 'stats']);

