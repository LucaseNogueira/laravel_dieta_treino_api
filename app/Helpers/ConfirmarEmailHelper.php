<?php

namespace App\Helpers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ConfirmarEmailHelper{

    public static function hash(Usuario $usuario):string
    {
        $chave = self::getChave($usuario);

        return Hash::make($chave);
    }

    public static function checkHash(string $hashedStr, Usuario $usuario):bool
    {
        $chave = self::getChave($usuario);

        return Hash::check($chave, $hashedStr);
    }

    private static function getChave(Usuario $usuario):string
    {
        $id = $usuario->id;
        $id_length = strlen($id . '');
        $nome_length = strlen($usuario->nome);

        return implode('_', [$id_length, $id, $nome_length]);
    }
}
