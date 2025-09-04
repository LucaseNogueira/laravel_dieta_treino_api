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
            'email' => 'teste@example.com',
            'status' => UsuarioStatus::ATIVO
        ]);
    }
}
