<?php

use App\Models\ClasseAtivo;
use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $classesAtivos = [
        [
            "nome" => "FII",
            "descricao" => "Fundos Imobiliários"
        ],
        [
            "nome" => "Ações",
            "descricao" => "Ações - B3"
        ],
        [
            "nome" => "Stablecoin",
            "descricao" => "Criptoativos"
        ],
        [
            "nome" => "Cripto",
            "descricao" => "Criptomoedas"
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->classesAtivos as $classeAtivo) {
            $classeAtivo['nome_interno'] = Str::slug($classeAtivo['nome'], '-');
            ClasseAtivo::create($classeAtivo);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->classesAtivos as $classeAtivo) {
            ClasseAtivo::where('nome_interno', Str::slug($classeAtivo['nome'], '-'))->delete();
        }
    }
};
