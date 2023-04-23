<?php

namespace Database\Factories;

use App\Models\Ativo;
use App\Models\ClasseAtivo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class AtivoFactory extends Factory
{
    protected $model = Ativo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'codigo' => fake()->randomLetter().fake()->randomLetter().fake()->randomLetter().rand(1, 9),
            'classe_ativo_uid' => ClasseAtivo::all()->random()->uid,
            'nome' => fake()->name(),
            'setor' => fake()->text(60)
        ];
    }
}
