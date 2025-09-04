<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Root"},
     *     summary="Endpoint raiz da API",
     *     description="Retorna uma mensagem de teste 'Hello World'. Útil para verificar se a API está no ar.",
     *     @OA\Response(
     *         response=200,
     *         description="Requisição executada com sucesso",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Hello World"
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json('Hello World', 200);
    }
}
