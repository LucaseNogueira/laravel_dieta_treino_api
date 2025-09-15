<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Usuario;

class LoginUsuarioApiTest extends TestCase
{
    // public static function setUpBeforeClass(): void
    // {
    //     parent::setUpBeforeClass();

    //     Usuario::factory()->create([
    //         'nome' => 'Teste',
    //         'email' => 'teste@phpunit.com',
    //         'senha' => 'senha',
    //         'status' => 'Ativo',
    //     ]);
    // }

    // public static function tearDownAfterClass():void
    // {
    //     Usuario::where([
    //         ['nome', '=', 'Teste'],
    //         ['email', '=', 'teste@phpunit.com'],
    //         ['status', '=', 'Ativo'],
    //     ])->delete();
    // }

    public function test_case_login_usuario(): void
    {
        $payload = [
            'email' => 'teste@phpunit.com',
            'senha' => 'senha'
        ];

        $response = $this->postJson('/api/auth', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'type', 'expires_in']);
    }

    public function test_case_email_invalido():void
    {
        $payloadSemEmail = [
            'senha' =>'senha'
        ];
        $responseSemEmail = $this->postJson('/api/auth', $payloadSemEmail);
        $responseSemEmail->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'email' => [
                        'O e-mail não foi informado ou esta inválido'
                    ]
                ]
            ]
        );

        $payloadEmailInvalido = [
            'email' => 'teste.phpunit.com',
            'senha' => 'senha'
        ];
        $responseEmailInvalido = $this->postJson('/api/auth', $payloadEmailInvalido);
        $responseEmailInvalido->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'email' => [
                        'O e-mail não foi informado ou esta inválido'
                    ]
                ]
            ]
        );
    }

    public function test_case_login_invalido():void
    {
        $payloadEmailNaoCadastrado = [
            'email' => 'email_nao_cadastrado@meuemail.com',
            'senha' => 'senha'
        ];
        $responseEmailNaoCadastrado = $this->postJson('/api/auth', $payloadEmailNaoCadastrado);
        $responseEmailNaoCadastrado->assertStatus(401)
            ->assertJsonFragment(['message' => 'Credenciais inválidas.']);

        $payloadSenhaIncorreta = [
            'email' => 'teste@phpunit.com',
            'senha' => 'password0'
        ];
        $responseSenhaIncorreta = $this->postJson('/api/auth', $payloadSenhaIncorreta);
        $responseSenhaIncorreta->assertStatus(401)
            ->assertJsonFragment(['message' => 'Credenciais inválidas.']);
    }

    public function test_case_senha_nao_informada():void
    {
        $payloadSemSenha = [
            'email' => 'teste@ativo.com'
        ];
        $responseSemSenha = $this->postJson('/api/auth', $payloadSemSenha);
        $responseSemSenha->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'senha' => [
                        'Senha não foi informada ou incorreta (minimo de 5 caracteres)'
                    ]
                ]
            ]
        );


        $payloadSenhaIncorreta = [
            'email' => 'teste@ativo.com',
            'senha' => 'abc'
        ];
        $responseSenhaIncorreta = $this->postJson('/api/auth', $payloadSenhaIncorreta);
        $responseSenhaIncorreta->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'senha' => [
                        'Senha não foi informada ou incorreta (minimo de 5 caracteres)'
                    ]
                ]
            ]
        );
    }
}
