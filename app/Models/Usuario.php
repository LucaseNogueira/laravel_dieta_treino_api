<?php

namespace App\Models;

use App\Enums\UsuarioStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable implements MustVerifyEmail
{

    use HasFactory, Notifiable;

    protected $table = 'usuario';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'status'
    ];

    protected $hidden = [
        'senha'
    ];

    protected $casts = [
        'email_verificado' => 'datetime',
        'senha' => 'hashed',
        'status' => UsuarioStatus::class
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verificado);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verificado' => now(),
            'status' => UsuarioStatus::ATIVO
        ]);
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
}
