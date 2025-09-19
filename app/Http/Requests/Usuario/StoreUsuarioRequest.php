<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:60',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:5'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo "nome" é obrigatório.',
            'nome.max' => 'O campo "nome" não pode ter mais que 60 caracteres.',
            'email.required' => 'O campo "e-mail" é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Credenciais inválidas: o e-mail informado já possui cadastro no sistema.',
            'senha.required' => 'O campo "senha" é obrigatório.',
            'senha.min' => 'O campo "senha" requer, no minimo, 5 caracteres'
        ];
    }
}
