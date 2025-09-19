<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    public function getInstanceService()
    {
        return new AuthService();
    }

    /**
     * @OA\Post(
     *  path="api/auth",
     *  tags={"Autenticação"},
     *  summary="Autenticação do usuário, retornando seu token JWT",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"email", "senha"},
     *          @OA\Property(property="email", type="string", format="email", example="teste@phpunit.com"),
     *          @OA\Property(property="senha", type="string", example="senha")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Login bem-sucedido, retorna token JWT",
     *      @OA\JsonContent(
     *          @OA\Property(property="token", type="string"),
     *          @OA\Property(property="type", type="string", example="Bearer"),
     *          @OA\Property(property="expires_in", type="integer", example="86400")
     *      )
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Credenciais inválidas"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Erro de validação",
     *      @OA\JsonContent(
     *          @OA\Property(property="errors", type="object",
     *              @OA\Property(property="email", type="array", @OA\Items(type="string", example="O e-mail não foi informado ou está inválido")),
     *              @OA\Property(property="senha", type="array", @OA\Items(type="string", example="Senha não foi informada ou incorreta (mínimo de 5 caracteres)"))
     *          )
     *      )
     *  )
     * )
     */
    public function login(LoginAuthRequest $request){
        $data = $request->only(['email', 'senha']);

        $aToken = $this->getInstanceService()->autenticarUsuario($data);

        return response()->json($aToken, 200);
    }
}
