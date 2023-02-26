<?php

namespace App\Jobs;

use App\Models\Cotacao;
use Illuminate\Bus\Queueable;
use App\Interfaces\ICotacaoBrapi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SalvarAcoesEFIICotacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $ativos;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $ativos)
    {
        $this->ativos = $ativos;
    }

    /**
     * Execute the job.
     */
    public function handle(ICotacaoBrapi $cotacaoBrapiService): void
    {

        try {
            $ativosImpleded = $this->ativos->implode('codigo', ',');
            $cotacaoAtivos = $cotacaoBrapiService->getCotacoes($ativosImpleded);

            if (empty($cotacaoAtivos)) {
                throw new \Exception("Não há cotações para os ativos: {$ativosImpleded}");
            }

            foreach ($cotacaoAtivos['results'] as $cotacao) {
                Cotacao::create([
                    'ativo_uid' => $this->ativos->firstWhere('codigo', $cotacao['symbol'])->uid,
                    'moeda_ref' => $cotacao['currency'],
                    'preco' => $cotacao['regularMarketPrice'] ?? '0.0',
                ]);
            }


            send_log('Cotações dos ativos', [
                "ativos" => $ativosImpleded,
                "Total"  => count($cotacaoAtivos['results'])
            ]);

        } catch (\Exception $exception) {
            send_log(
                'Error ao tentar salvar as cotações de ações e FIIs',
                [],
                $exception,
                'error'
            );

            $this->fail($exception);
        }

    }
}
