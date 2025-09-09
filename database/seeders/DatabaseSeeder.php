<?php

namespace Database\Seeders;

use App\Enums\UsuarioStatus;
use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory()->create([
            'nome' => 'Teste',
            'email' => 'teste@ativo.com',
            'status' => UsuarioStatus::ATIVO
        ]);
        Usuario::factory()->create([
            'nome' => 'Teste Pendente',
            'email' => 'teste@pendente.com',
            'status' => UsuarioStatus::PENDENTE,
            'email_verificado' => null
        ]);
    }
}
