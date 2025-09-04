<?php

namespace App\Http\Controllers;

define('APP_NAME', env('APP_NAME', 'Laravel Dieta e Treino API'));
define('APP_VERSION', env('APP_VERSION', '1.0.0'));
define('APP_URL', env('APP_URL', 'http://localhost/api'));
define('APP_DESCRIPTION', env('APP_DESCRIPTION', 'Doc da APP'));

/**
 * @OA\Info(
 *     version=APP_VERSION,
 *     title=APP_NAME,
 *     description=APP_DESCRIPTION
 * )
 *
 * @OA\Server(
 *     url=APP_URL,
 *     description="Servidor principal"
 * )
 */
abstract class Controller
{
    //
}
