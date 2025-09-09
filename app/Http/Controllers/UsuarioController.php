<?php

namespace App\Http\Controllers;

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

    }
}
