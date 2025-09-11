<?php

namespace App\Http\Services;

use App\Enums\UsuarioStatus;
use App\Helpers\ConfirmarEmailHelper;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService{

    public function criarUsuario(array $dados):Usuario
    {
        $dados['status'] = UsuarioStatus::PENDENTE;

        $usuario = Usuario::create($dados);

        return $usuario;
    }

    public function confirmarUsuario(string $hashConfirmacao){
        $usuarios = Usuario::where('status', UsuarioStatus::PENDENTE)->get();

        foreach($usuarios as $user){
            if(ConfirmarEmailHelper::checkHash($hashConfirmacao, $user)){
                $user->status = UsuarioStatus::ATIVO;
                $user->save();
                return true;
            }
        }

        return false;
    }
}
