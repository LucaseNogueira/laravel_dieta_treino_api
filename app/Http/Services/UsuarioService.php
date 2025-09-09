<?php

namespace App\Http\Services;

use App\Enums\UsuarioStatus;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService{

    public function criarUsuario(array $dados):Usuario
    {
        $dados['status'] = UsuarioStatus::PENDENTE;

        $usuario = Usuario::create($dados);

        return $usuario;
    }
}
