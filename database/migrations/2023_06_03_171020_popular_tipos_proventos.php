<?php

use App\Models\TipoProvento;
use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $tiposProventos = [
        [
            "nome" => "Dividendo"
        ],
        [
            "nome" => "Provento"
        ],
        [
            "nome" => "JCP"
        ],
        [
            "nome" => "Rendimento"
        ],
        [
            "nome" => "Amortização"
        ],
        [
            "nome" => "Rend. Tributado"
        ],
        [
            "nome" => "Outro"
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tiposProventos as $tipoProvento) {
            $tipoProvento['nome_interno'] = Str::slug($tipoProvento['nome'], '-');
            TipoProvento::create($tipoProvento);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tiposProventos as $tipoProvento) {
            TipoProvento::where('nome_interno', Str::slug($tipoProvento['nome'], '-'))->delete();
        }
    }
};
