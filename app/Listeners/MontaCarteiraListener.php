<?php

namespace App\Listeners;

use Throwable;
use App\Models\Carteira;
use App\Models\Operacao;
use App\Events\ConsolidaCarteiraEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MontaCarteiraListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ConsolidaCarteiraEvent $event): void
    {
        $operacoesAtivos = Operacao::select('operacoes.*', 'ativos.codigo AS codigo_ativo', 'tipos_operacoes.nome_interno AS tipo_operacao')
            ->join('ativos', 'operacoes.ativo_uid', '=', 'ativos.uid')
            ->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid')
            ->where('user_uid', $event->userUid)
            ->get();

        foreach ($operacoesAtivos->groupBy('codigo_ativo') as $operacoes) {

            $somaOperacoesCompras = $operacoes->where('tipo_operacao', 'compra')->sum('quantidade');
            $somaOperacoesVendas = $operacoes->where('tipo_operacao', 'venda')->sum('quantidade');
            $somaValorTotal = $operacoes->where('tipo_operacao', 'compra')->sum('valor_total');

            $quantidadeSaldo = ($somaOperacoesCompras - $somaOperacoesVendas);
            $precoMedio = ($somaValorTotal / $somaOperacoesCompras);

            // TODO: Alterar para repository
            Carteira::updateOrCreate([
                'user_uid' => $event->userUid,
                'ativo_uid' => $operacoes->first()->ativo_uid,
            ],
            [
                'quantidade' => $quantidadeSaldo,
                'preco_medio' => $precoMedio,
                'custo_total' => $quantidadeSaldo * $precoMedio
            ]);
        }
    }

    public function failed(ConsolidaCarteiraEvent $event, Throwable $e): void
    {
        send_log('Erro ao montar carteira', [], 'error', $e);
    }
}
