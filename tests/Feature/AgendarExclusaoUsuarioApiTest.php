<?php

namespace Tests\Feature;

use App\Enums\UsuarioStatus;
use App\Models\Usuario;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgendarExclusaoUsuarioApiTest extends AuthPadraoTestCase
{
    private $token;
    private $usuario;

    protected function setUp():void
    {
        parent::setUp();

        if(!$this->usuario){
            $this->usuario = $this->criarUsuario([
                'nome' => "Teste Agendamento",
                'status' => UsuarioStatus::ATIVO,
                'email' => "testeagendamento@meuemail.com",
                'senha' => Hash::make('senha')
            ]);
            $this->token = $this->autenticarUsuario($this->usuario->email)['token'];
        }

    }
    /**
     * A basic feature test example.
     */
    public function test_case_usuario_exclusao_pendente(): void
    {
        $path = 'api/user';

        $response = $this->authorization()->deleteJson($path);

        $response->assertStatus(202)
            ->assertJson([
                'message' => "Usuário em processo de exclusão",
                'id' => $this->usuario->id
            ]);
    }

    // public function test_case_executar_agendamento_exclusao_pendente():void
    // {

    // }
}
