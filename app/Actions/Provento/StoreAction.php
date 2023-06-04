<?php

namespace App\Actions\Provento;

use App\DTOs\Provento\StoreProventoDTO;
use App\Interfaces\Repositories\IProventoRepository;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function __construct(
        private IProventoRepository $proventoRepository,
    )
    {}

    public function execute(array $provento = []): array
    {
        $storeProventoDTO = new StoreProventoDTO($provento);
        $storeProventoDTO->user_uid = Auth::user()->uid;

        $storeProventoDTO->valor_total = $storeProventoDTO->valor * $storeProventoDTO->quantidade_ativo;

        // TODO: Pegar o preço medio para calcular yield_on_cost
        // $precoMedio = 95.00;
        // $custoDoAtivos = ($precoMedio * $storeProventoDTO->quantidade_ativo);
        // $storeProventoDTO->yield_on_cost = ($storeProventoDTO->valor_total / $custoDoAtivos) * 100;
        $storeProventoDTO->yield_on_cost = 0.0;

        return $this->proventoRepository->store($storeProventoDTO);
    }
}
