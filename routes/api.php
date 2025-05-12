<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('users',[UserController::class,'showUsers']);
Route::post('users', [UserController::class, 'register']);
