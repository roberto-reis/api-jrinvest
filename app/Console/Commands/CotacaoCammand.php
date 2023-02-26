<?php

namespace App\Console\Commands;

use App\Models\ClasseAtivo;
use Illuminate\Console\Command;
use App\Jobs\SalvarAcoesEFIICotacaoJob;
use App\Jobs\SalvarCriptoativosCotacaoJob;

class CotacaoCammand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:cotacao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualização de cotação de ações, FII e criptomoedas';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $classesAtivos = ClasseAtivo::with('ativos')
                                    ->has('ativos')
                                    ->get();

        if (empty($classesAtivos)) {
            throw new \Exception('Não há Classe de Ativos cadastradas');
        }

        foreach ($classesAtivos as $classeAtivo) {
            switch ($classeAtivo['nome_interno']) {
                case 'acoes':
                case 'fii':
                    SalvarAcoesEFIICotacaoJob::dispatch($classeAtivo->ativos);
                    break;
                case 'cripto':
                case 'stablecoin':
                    SalvarCriptoativosCotacaoJob::dispatch($classeAtivo->ativos);
                    break;
            }
        }
    }
}
