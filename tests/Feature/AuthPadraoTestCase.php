<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Tests\TestCase;

abstract class AuthPadraoTestCase extends TestCase
{
    private $token;
    private $usuario;

    protected function criarUsuario(array $dados):Usuario
    {
        return Usuario::factory()->create($dados);
    }

    protected function autenticarUsuario(String $email){
        $usuario = Usuario::where('email', $email)->firstOrFail();
        return [
            'usuario' => $usuario,
            'token' => auth('api')->login($usuario)
        ];
    }

    protected function authorization(){
        return $this->withHeaders([
            'Authorization' => 'Baerer ' . $this->token
        ]);
    }
}
