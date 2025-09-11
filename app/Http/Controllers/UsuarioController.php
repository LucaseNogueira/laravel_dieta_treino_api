<?php

namespace App\Http\Controllers;

use App\Events\AfterCadastroUsuario;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function getInstanceService():UsuarioService
    {
        return new UsuarioService();
    }

    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->only(['nome', 'email', 'senha']);
        $usuario = $this->getInstanceService()->criarUsuario($data);

        event(new AfterCadastroUsuario($usuario));

        return response()->json($usuario, 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function confirm(string $hash){
        $isConfirm = $this->getInstanceService()->confirmarUsuario($hash);
        if($isConfirm){
            return response()->json(
                'Confirmado o cadastro do seu usuário. Agora você pode acessar a API!',
                200
            );
        }

        return response()->json(
            'Credenciais inválidas',
            404
        );
    }
}
