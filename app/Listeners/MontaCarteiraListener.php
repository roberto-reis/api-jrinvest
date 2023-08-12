<?php

namespace App\Listeners;

use Throwable;
use App\Events\ConsolidaCarteiraEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;
use App\Interfaces\Repositories\ICarteiraRepository;

class MontaCarteiraListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private ICarteiraRepository $carteiraRepository)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(ConsolidaCarteiraEvent $event): void
    {
        $operacoesAtivos = $this->carteiraRepository->getAllByUser($event->userUid);

        foreach ($operacoesAtivos as $ativoUid => $operacoes) {

            $somaOperacoesCompras = $operacoes->where('tipo_operacao', 'compra')->sum('quantidade');
            $somaOperacoesVendas = $operacoes->where('tipo_operacao', 'venda')->sum('quantidade');
            $somaValorTotal = $operacoes->where('tipo_operacao', 'compra')->sum('valor_total');

            $quantidadeSaldo = ($somaOperacoesCompras - $somaOperacoesVendas);
            $precoMedio = ($somaValorTotal / $somaOperacoesCompras);

            $dto = new CarteiraUpdateOrCreateDTO();
            $dto->user_uid = $event->userUid;
            $dto->ativo_uid = $ativoUid;
            $dto->quantidade = $quantidadeSaldo;
            $dto->preco_medio = $precoMedio;
            $dto->custo_total = $quantidadeSaldo * $precoMedio;

            $this->carteiraRepository->updateOrCreate($dto);

        }
    }

    public function failed(ConsolidaCarteiraEvent $event, Throwable $e): void
    {
        send_log('Erro ao montar carteira', [], 'error', $e);
    }
}
