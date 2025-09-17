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

    public function confirmarUsuario(string $hashConfirmacao):bool
    {
        $usuarios = Usuario::where('status', UsuarioStatus::PENDENTE)->get();

        foreach($usuarios as $user){
            if(ConfirmarEmailHelper::checkHash($hashConfirmacao, $user)){
                $user->email_verificado = now();
                $user->status = UsuarioStatus::ATIVO;
                $user->save();
                return true;
            }
        }

        return false;
    }

    public function atualizarUsuario(array $data):Usuario
    {
        $usuario = Usuario::findOrFail($data['id']);
        $usuario->nome = $data['nome'];

        $usuario->save();

        return $usuario;
    }
}
