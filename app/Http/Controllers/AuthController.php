<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Services\AuthService;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getInstanceService()
    {
        return new AuthService();
    }

    public function login(LoginAuthRequest $request){
        $data = $request->only(['email', 'senha']);

        $aToken = $this->getInstanceService()->autenticarUsuario($data);

        return response()->json($aToken, 200);
    }
}
