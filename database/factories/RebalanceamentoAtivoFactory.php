<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ativo;
use App\Models\RebalanceamentoAtivo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class RebalanceamentoAtivoFactory extends Factory
{
    protected $model = RebalanceamentoAtivo::class;

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
            'percentual' => fake()->randomFloat(2, 1, 100)
        ];
    }
}
