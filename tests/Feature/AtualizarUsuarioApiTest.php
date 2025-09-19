<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AtualizarUsuarioApiTest extends TestCase
{
    use DatabaseTransactions;

    private $token;
    private $usuario;

    protected function setUp(): void
    {
        parent::setUp();

        if(!$this->token || !$this->usuario){
            $payload = [
                'email' => 'teste@phpunit.com',
                'senha' => 'senha'
            ];

            $this->usuario = Usuario::where('email', $payload['email'])->first();
            $this->token = auth('api')->login($this->usuario);
        }
    }

    public function test_case_usuario_atualizado(): void
    {
        $payload = [
            'nome' => 'Teste JoãoUnit'
        ];
        $path = 'api/user/' . $this->usuario->id;

        $response = $this->authorization()->putJson($path, $payload);

        $response->assertStatus(200)
            ->assertJson([
                'nome' => $payload['nome'],
                'status' => 'Ativo',
                'email' => $this->usuario->email
            ]);
    }

    public function test_case_nome_invalido(): void
    {
        $payload = [
            'nome' => 'Marco Antônio da Costa e Silva Santos Limeira Junior Neto Filho'
        ];
        $path = 'api/user/' . $this->usuario->id;

        $response = $this->authorization()->putJson($path, $payload);

        $response->assertStatus(422)
        ->assertJsonFragments([
            'nome' => [
                "Campo 'Nome' possui valor invalido com mais de 60 caracteres."
            ]
        ]);
    }

    public function test_case_request_vazia():void
    {
        $payload = ['nome' => ''];
        $path = 'api/user/' . $this->usuario->id;

        $response = $this->authorization()->putJson($path, $payload);

        $response->assertStatus(422)
        ->assertJsonFragments([
            'nome' => [
                "Não foi informado dados válidos para a atualização do usuário."
            ]
        ]);
    }

    protected function authorization(){
        return $this->withHeaders([
            'Authorization' => 'Baerer ' . $this->token
        ]);
    }
}
