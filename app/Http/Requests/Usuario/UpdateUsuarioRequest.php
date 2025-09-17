<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuarioAuth = auth('api')->user();
        $paramId = $this->route('id');

        return $usuarioAuth &&
                $usuarioAuth->id === (int) $paramId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'sometimes|required|string|max:60'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => "Não foi informado dados válidos para a atualização do usuário.",
            'nome.max' => "Campo 'Nome' possui valor invalido com mais de 60 caracteres."
        ];
    }
}
