<?php

namespace App\Models;

use App\Enums\UsuarioStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject, MustVerifyEmail
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'status'
    ];

    protected $hidden = [
        'senha',
        'updated_at',
        'created_at'
    ];

    protected $casts = [
        'email_verificado' => 'datetime',
        'senha' => 'hashed',
        'status' => UsuarioStatus::class
    ];

    protected $rememberTokenName = false;
    protected $authPasswordName = 'senha';

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

    /**
     * Compara a secret informada com a senha hasheada do usuário
     */
    public function comparaSenhas(string $secret):bool
    {
        return Hash::check($secret, $this->senha);
    }

    public function setSenhaAttribute(string $senha):void
    {
        $this->attributes['senha'] = Hash::make($senha);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [
            'email' => $this->email
        ];
    }
}
