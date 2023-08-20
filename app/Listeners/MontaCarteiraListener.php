<?php

namespace App\Listeners;

use Throwable;
use App\Events\ConsolidaCarteiraEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;
use App\Interfaces\Repositories\ICarteiraRepository;
use App\Interfaces\Repositories\IOperacaoRepository;

class MontaCarteiraListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private IOperacaoRepository $operacaoRepository,
        private CarteiraUpdateOrCreateDTO $carteiraUpdateOrCreateDTO
    )
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ConsolidaCarteiraEvent $event): void
    {
        $operacoesAtivos = $this->operacaoRepository->getAllByUser($event->userUid);

        foreach ($operacoesAtivos as $ativoUid => $operacoes) {

            $somaOperacoesCompras = $operacoes->where('tipo_operacao', 'compra')->sum('quantidade');
            $somaOperacoesVendas = $operacoes->where('tipo_operacao', 'venda')->sum('quantidade');
            $somaValorTotal = $operacoes->where('tipo_operacao', 'compra')->sum('valor_total');

            $quantidadeSaldo = ($somaOperacoesCompras - $somaOperacoesVendas);
            $precoMedio = ($somaValorTotal / $somaOperacoesCompras);

            $custoTotal = $quantidadeSaldo * $precoMedio;

            $dto = $this->carteiraUpdateOrCreateDTO->register(
                $event->userUid,
                $ativoUid,
                $quantidadeSaldo,
                $precoMedio,
                $custoTotal
            );

            $this->carteiraRepository->updateOrCreate($dto);

        }
    }

    public function failed(ConsolidaCarteiraEvent $event, Throwable $e): void
    {
        send_log('Erro ao montar carteira', [], 'error', $e);
    }
}
