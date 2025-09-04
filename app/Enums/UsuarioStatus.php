<?php

namespace App\Enums;

enum UsuarioStatus: string
{
    case ATIVO = 'Ativo';
    case PENDENTE = 'Pendente';
    case EXCLUSAO_PENDENTE = 'Exclusão Pendente';
}
