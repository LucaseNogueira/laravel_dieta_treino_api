<?php

namespace App\Http\Services;

use App\Enums\UsuarioStatus;
use App\Models\Usuario;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{

    public function autenticarUsuario(array $data):array
    {
        $data['password'] = $data['senha'];
        $data['status'] = UsuarioStatus::ATIVO;
        unset($data['senha']);

        if(!$token = Auth::guard('api')->attempt($data)){
            throw new AuthenticationException('Credenciais inválidas.');
        }

        return [
            'token' => $token,
            'type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }
}
