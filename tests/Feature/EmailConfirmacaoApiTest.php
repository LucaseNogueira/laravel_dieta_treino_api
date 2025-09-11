<?php

namespace Tests\Feature;

use App\Enums\UsuarioStatus;
use App\Helpers\ConfirmarEmailHelper;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmailConfirmacaoApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_case_usuario_confirmou_cadastro_via_email(): void
    {
        $usuario = Usuario::where('status', UsuarioStatus::PENDENTE)->first();
        $hashConfirmacao = ConfirmarEmailHelper::hash($usuario);

        $response = $this->get("/user/confirm/{$hashConfirmacao}");

        $response->assertStatus(200);
    }

    public function test_case_hash_invalida_rota_confirmacao_usuario():void
    {
        $usuario = Usuario::factory()->make();
        $usuario->id = 4;
        $hashConfirmacao = ConfirmarEmailHelper::hash($usuario);

        $response = $this->get("/user/confirm/{$hashConfirmacao}");

        $response->assertStatus(404);
    }
}
