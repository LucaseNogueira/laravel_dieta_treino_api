<?php

namespace App\Http\Services;

use App\Enums\UsuarioStatus;
use App\Helpers\ConfirmarEmailHelper;
use App\Interfaces\InterfaceService;
use App\Models\Usuario;
use App\Utils\IntUtils;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class UsuarioService implements InterfaceService{

    public function model(): Usuario
    {
        return new Usuario();
    }

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

    public function agendarExclusaoUsuario(int $id): int
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->status = UsuarioStatus::EXCLUSAO_PENDENTE;
        $usuario->save();

        return $id;
    }

    /**
     * @param int[] $ids
     */
    public function excluirUsuario(array $ids):bool
    {
        if(!IntUtils::apenasInteiros($ids)){
            throw new InvalidArgumentException("Todos os ids de usuário devem ser inteiros para acontecer a exclusão dos dados.");
        }

        DB::transaction(function () use($ids) {
            Usuario::whereIn('id', $ids)->delete();
        });

        return true;
    }
}
