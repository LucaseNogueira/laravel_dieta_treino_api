<?php

namespace App\Http\Controllers;

use App\Events\AfterCadastroUsuario;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Http\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function getInstanceService():UsuarioService
    {
        return new UsuarioService();
    }

    /**
     * @OA\Post(
     *  path="api/user",
     *  summary="Cadastro do Usuário",
     *  description="Cadastro completo de um usuário no sistema.",
     *  tags={"Usuário"},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"nome", "email", "senha"},
     *          @OA\Property(property="nome", type="string", example="Teste OpenAPI"),
     *          @OA\Property(property="email", type="string", example="teste_openapi@email.com"),
     *          @OA\Property(property="senha", type="string", example="senha_openapi")
     *      )
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Sucesso",
     *      @OA\JsonContent(
     *          @OA\Property(property="id", type="integer"),
     *          @OA\Property(property="nome", type="string", example="Teste OpenAPI"),
     *          @OA\Property(property="email", type="string", format="email", example="teste_openapi@email.com"),
     *          @OA\Property(property="status", type="string", example="Pendente"),
     *      )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Erro"
     *      @OA\JsonContent(
     *          @OA\Property(property="errors", type="object",
     *              @OA\Property(property="email", type="array",
     *                  @OA\Items(type="string", example="Credenciais inválidas: o e-mail informado já possui cadastro no sistema."),
     *                  @OA\Items(type="string", example="O campo "e-mail" é obrigatório."),
     *                  @OA\Items(type="string", example="Informe um endereço de e-mail válido.")
     *              ),
     *              @OA\Property(property="nome", type="array",
     *                  @OA\Items(type="string, example="O campo "nome" é obrigatório."),
     *                  @OA\Items(type="string, example="O campo "nome" não pode ter mais que 60 caracteres.")
     *              ),
     *              @OA\Property(property="senha", type="array",
     *                  @OA\Items(type="string", example="O campo "senha" é obrigatório."),
     *                  @OA\Items(type="string", example="O campo "senha" requer, no minimo, 5 caracteres"),
     *              )
     *          )
     *      )
     *  )
     * )
     */
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

    public function update(UpdateUsuarioRequest $request, string $id)
    {
        $data = $request->only(['nome']);
        $data['id'] = (int) $id;

        $usuario = $this->getInstanceService()->atualizarUsuario($data);

        return response()->json($usuario, 200);
    }

    public function destroy(string $id)
    {
        //
    }

    /**
     * @OA\Get(
     *  path="/user/confirm/{hash}",
     *  summary="Confirmar cadastro do usuário",
     *  tags={"Usuário"},
     *  @OA\Parameter(
     *      name="hash",
     *      in="path",
     *      required=true,
     *      description="Hash enviado por e-mail para confirmação do usuário",
     *      @OA\Schema(type="string")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Confirmado o cadastro do seu usuário. Agora você pode acessar a API!"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Credenciais inválidas"
     *  )
     * )
     */
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
