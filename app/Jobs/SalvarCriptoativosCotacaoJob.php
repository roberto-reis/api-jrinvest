<?php

namespace App\Jobs;

use Throwable;
use App\Models\Cotacao;
use Illuminate\Bus\Queueable;
use App\Interfaces\ICotacaoBrapi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SalvarCriptoativosCotacaoJob implements ShouldQueue
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
        $ativosImploded = $this->ativos->implode('codigo', ',');
        $cotacaoCriptos = $cotacaoBrapiService->getCotacoesCripto($ativosImploded);

        if (empty($cotacaoCriptos)) {
            throw new \Exception("Não há cotações para os ativos: {$ativosImploded}");
        }

        foreach ($cotacaoCriptos['coins'] as $cotacao) {
            Cotacao::create([
                'ativo_uid' => $this->ativos->firstWhere('codigo', $cotacao['coin'])->uid,
                'moeda_ref' => $cotacao['currency'],
                'preco' => $cotacao['regularMarketPrice'] ?? '0.0',
            ]);
        }

        send_log('Cotações dos criptoativos', [
            "ativos" => $ativosImploded,
            "Total"  => count($cotacaoCriptos['coins'])
        ]);

    }

    public function failed(Throwable $exception)
    {
        send_log(
            'Error ao tentar salvar as cotações de ações e FIIs',
            [],
            'error',
            $exception
        );
    }
}
