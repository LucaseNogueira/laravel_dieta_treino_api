<?php

namespace App\Http\Middleware;

use App\Enums\UsuarioStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioAutenticadoAtivoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('api')->user()->status != UsuarioStatus::ATIVO){
            return response()->json(['error' => "Usuário autenticado não esta ativo no sistema. Confirme o cadastro via e-mail ou contate o suporte."], 403);
        }

        return $next($request);
    }
}
