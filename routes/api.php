<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('user', [UsuarioController::class, 'store']);
Route::post('/auth', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::put('user/{id}', [UsuarioController::class, 'update']);
});
