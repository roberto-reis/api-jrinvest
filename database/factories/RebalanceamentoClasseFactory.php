<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ClasseAtivo;
use App\Models\RebalanceamentoClasse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class RebalanceamentoClasseFactory extends Factory
{
    protected $model = RebalanceamentoClasse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_uid' => User::factory()->create()->uid,
            'classe_ativo_uid' => ClasseAtivo::all()->random()->uid,
            'percentual' => fake()->randomFloat(2, 1, 100)
        ];
    }
}
