<?php

namespace Tests\Feature;

use App\Http\Services\UsuarioService;
use App\Jobs\ConfirmarEmailJob;
use App\Mail\ConfirmarCadastroMail;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CadastrarUsuarioApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testa a criação do usuário e o envio de email pela rota de cadastro de usuário.
     */
    public function test_case_cadastro_do_usuario(): void
    {
        Queue::fake();

        $payload = [
            'nome' => 'João Testcase',
            'email' => 'joao_testcase@meuemail.com',
            'senha' => 'testcase_joao'
        ];

        $response = $this->postJson('/api/user', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'nome' => 'João Testcase',
            'email' => 'joao_testcase@meuemail.com',
            'status' => 'Pendente',
        ]);

        Queue::assertPushed(ConfirmarEmailJob::class, function($job) use ($payload){
            return $job->usuario->email === $payload['email'];
        });
    }

    public function test_case_cadastro_com_email_duplicado():void
    {
        $payload = [
            'nome' => 'João Testcase Jr',
            'email' => 'teste@pendente.com',
            'senha' => 'teste_joao_jr',
        ];

        $response = $this->postJson('/api/user', $payload);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'email' => [
                    'Credenciais inválidas: o e-mail informado já possui cadastro no sistema.'
                ]
            ]
        ]);
    }

    public function test_case_cadastro_com_nome_invalido():void
    {
        $payloadSemNome = [
            'email' => 'meu@email.com',
            'senha' => 'sem_nome'
        ];
        $responseSemNome = $this->postJson('/api/user', $payloadSemNome);
        $responseSemNome->assertStatus(422);
        $responseSemNome->assertJsonFragment([
            'errors' => [
                'nome' => [
                    'O campo "nome" é obrigatório.'
                ]
            ]
        ]);

        $payloadMaisDeSessenta = [
            'nome' => 'Mario de Alessander Geovani David de Castro Nobre Schweinsteiger Jr',
            'email' => 'mario_jr@meuemail.com',
            'senha' => 'Schweinsteiger_jr'
        ];
        $responseMaisDeSessenta = $this->postJson('/api/user', $payloadMaisDeSessenta);
        $responseMaisDeSessenta->assertStatus(422);
        $responseMaisDeSessenta->assertJsonFragment([
            'errors' => [
                'nome' => [
                    'O campo "nome" não pode ter mais que 60 caracteres.'
                ]
            ]
        ]);
    }

    public function test_case_cadastro_com_email_invalido():void
    {
        $payloadSemEmail = [
            'nome' => 'João Testcase',
            'senha' => 'sem_email'
        ];
        $responseSemEmail = $this->postJson('/api/user', $payloadSemEmail);
        $responseSemEmail->assertStatus(422);
        $responseSemEmail->assertJsonFragment([
            'errors' => [
                'email' => [
                    'O campo "e-mail" é obrigatório.'
                ]
            ]
        ]);

        $payloadEmailInvalido = [
            'nome' => 'João Testcase',
            'email' => 'joao_testcase.meuemail.com',
            'senha' => 'email_sem_@'
        ];
        $responseEmailInvalido  = $this->postJson('/api/user', $payloadEmailInvalido);
        $responseEmailInvalido->assertStatus(422);
        $responseEmailInvalido->assertJsonFragment([
            'errors' => [
                'email' => [
                    'Informe um endereço de e-mail válido.'
                ]
            ]
        ]);
    }

    public function test_case_cadastro_sem_informar_senha():void
    {
        $payload = [
            'nome' => 'João Testcase',
            'email' => 'joao_testcase@email.com'
        ];
        $response = $this->postJson('/api/user', $payload);
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'senha' => [
                    'O campo "senha" é obrigatório.'
                ]
            ]
        ]);

        $payloadMenosDeCinco = [
            'nome' => 'João Testcase',
            'email' => 'joao_testcase@email.com',
            'senha' => 'guri'
        ];
        $responseMenosDeCinco = $this->postJson('/api/user', $payloadMenosDeCinco);
        $responseMenosDeCinco->assertStatus(422);
        $responseMenosDeCinco->assertJson([
            'errors' => [
                'senha' => [
                    'O campo "senha" requer, no minimo, 5 caracteres'
                ]
            ]
        ]);
    }

    public function test_case_criptografia_senha():void
    {
        $payload = [
            'nome' => 'João Testcase',
            'email' => 'joao_testcase@meuemail.com',
            'senha' => 'testcase_joao'
        ];

        $service = new UsuarioService();
        $usuario = $service->criarUsuario($payload);

        $this->assertTrue($usuario->comparaSenhas('testcase_joao'));
        $this->assertFalse($usuario->comparaSenhas('Testcase_joao'));
    }

    public function test_case_job_email_confirmacao_usuario():void
    {
        Mail::fake();

        $usuario = Usuario::factory()->make();

        $job = new ConfirmarEmailJob($usuario);
        $job->handle();

        Mail::assertSent(ConfirmarCadastroMail::class, function ($mail) use ($usuario) {
            return $mail->hasTo($usuario->email);
        });
    }
}
