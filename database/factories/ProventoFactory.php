<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ativo;
use App\Models\Provento;
use App\Models\Corretora;
use App\Models\TipoProvento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class ProventoFactory extends Factory
{
    protected $model = Provento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_uid' => User::factory()->create()->uid,
            'ativo_uid' => Ativo::factory()->create()->uid,
            'tipo_provento_uid' => TipoProvento::all()->random()->uid,
            'corretora_uid' => Corretora::all()->random()->uid,
            'data_com' => fake()->date(),
            'data_pagamento' => fake()->date(),
            'quantidade_ativo' => fake()->randomFloat(2, 0.1, 9999),
            'valor' => fake()->randomFloat(2, 0.1, 9999),
            'yield_on_cost' => fake()->randomFloat(2, 0.1, 100.00)
        ];
    }
}
