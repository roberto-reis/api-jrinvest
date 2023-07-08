<?php

use App\Models\TipoOperacao;
use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $tiposOperacoes = [
        [
            "nome" => "Compra"
        ],
        [
            "nome" => "Venda"
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tiposOperacoes as $tipoOperacao) {
            $tipoOperacao['nome_interno'] = Str::slug($tipoOperacao['nome'], '-');
            TipoOperacao::create($tipoOperacao);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tiposOperacoes as $tipoOperacao) {
            TipoOperacao::where('nome_interno', Str::slug($tipoOperacao['nome'], '-'))->delete();
        }
    }
};
