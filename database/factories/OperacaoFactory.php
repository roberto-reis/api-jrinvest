<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ativo;
use App\Models\Operacao;
use App\Models\Corretora;
use App\Models\TipoOperacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class OperacaoFactory extends Factory
{
    protected $model = Operacao::class;

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
            'tipo_operacao_uid' => TipoOperacao::all()->random()->uid,
            'corretora_uid' => Corretora::all()->random()->uid,
            'cotacao_preco' => fake()->randomFloat(2, 0.01, 500.00),
            'quantidade' => fake()->randomFloat(2, 0.01, 500.00),
            'data_operacao' => fake()->date(),
        ];
    }
}
