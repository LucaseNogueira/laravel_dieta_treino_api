<?php

namespace Database\Factories;

use App\Enums\UsuarioStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected static ?string $senha;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verificado' => now(),
            'senha' => static::$senha ??= Hash::make('senha'),
            'status' => UsuarioStatus::cases()[array_rand(UsuarioStatus::cases())]
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verificado' => null,
        ]);
    }
}
