<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/user', UsuarioController::class);
Route::post('/auth', [AuthController::class, 'login']);
