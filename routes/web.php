<?php

use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelloWorldController::class, 'index']);

Route::get('/user/confirm/{hash}', [UsuarioController::class, 'confirm']);
