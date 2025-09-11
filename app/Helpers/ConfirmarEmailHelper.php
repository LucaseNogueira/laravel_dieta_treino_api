<?php

namespace App\Helpers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ConfirmarEmailHelper{

    public static function hash(Usuario $usuario):string
    {
        return hash_hmac('sha256', self::getChave($usuario), config('app.key'));
    }

    public static function checkHash(string $hashedStr, Usuario $usuario):bool
    {
        return hash_equals(
            $hashedStr,
            self::hash($usuario)
        );
    }

    private static function getChave(Usuario $usuario):string
    {
        $id = $usuario->id;
        $id_length = strlen($id . '');
        $nome_length = strlen($usuario->nome);

        return implode('_', [$id_length, $id, $nome_length]);
    }
}
