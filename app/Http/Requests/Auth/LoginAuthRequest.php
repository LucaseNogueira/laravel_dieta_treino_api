<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginAuthRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'email|required',
            'senha' => 'required|min:5'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'O e-mail não foi informado ou esta inválido',
            'email.required' => 'O e-mail não foi informado ou esta inválido',
            'senha.required' => 'Senha não foi informada ou incorreta (minimo de 5 caracteres)',
            'senha.min' => 'Senha não foi informada ou incorreta (minimo de 5 caracteres)'
        ];
    }
}
