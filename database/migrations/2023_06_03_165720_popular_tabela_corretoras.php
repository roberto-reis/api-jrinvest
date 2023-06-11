<?php

use App\Models\Corretora;
use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $corretoras = [
        [
            "nome" => "Clear"
        ],
        [
            "nome" => "XP Investimentos"
        ],
        [
            "nome" => "Itaú"
        ],
        [
            "nome" => "Santander"
        ],
        [
            "nome" => "Bradesco"
        ],
        [
            "nome" => "Banco Inter"
        ],
        [
            "nome" => "Rico Investimentos"
        ],
        [
            "nome" => "Guide Investimentos"
        ],
        [
            "nome" => "Modalmais"
        ],
        [
            "nome" => "Binance"
        ],
        [
            "nome" => "Mercado Bitcoin"
        ],
        [
            "nome" => "Nu invest"
        ],
        [
            "nome" => "BTG Pactual"
        ],
        [
            "nome" => "Avenue"
        ],
        [
            "nome" => "Passfolio"
        ],
        [
            "nome" => "Órama"
        ],
        [
            "nome" => "Íon Itaú"
        ],
        [
            "nome" => "TD Ameritrade"
        ],
        [
            "nome" => "Foxbit"
        ],
        [
            "nome" => "Toro Investimentos"
        ],
        [
            "nome" => "BitcoinTrade"
        ],
        [
            "nome" => "NovaDAX"
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->corretoras as $corretora) {
            $corretora['nome_interno'] = Str::slug($corretora['nome'], '-');
            Corretora::create($corretora);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->corretoras as $corretora) {
            Corretora::where('nome_interno', Str::slug($corretora['nome'], '-'))->delete();
        }
    }
};
