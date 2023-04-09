<?php

namespace Database\Factories;

use App\Models\ClasseAtivo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAtivo>
 */
class ClasseAtivoFactory extends Factory
{
    protected $model = ClasseAtivo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = fake()->name();
        return [
            'nome' => $nome,
            'nome_interno' => Str::slug($nome, '-'),
            'descricao' => fake()->text(50)
        ];
    }
}
