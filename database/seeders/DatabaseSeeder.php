<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Ativo;
use App\Models\ClasseAtivo;
use Illuminate\Database\Seeder;
use App\Models\RebalanceamentoClasse;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::factory(2)->create();
        // ClasseAtivo::factory(5)->create();
        // Ativo::factory(5)->create();
        RebalanceamentoClasse::factory(5)->create();
    }
}
