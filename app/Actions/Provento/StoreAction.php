<?php

namespace App\Actions\Provento;

use App\DTOs\Provento\ProventoDTO;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IProventoRepository;

class StoreAction
{
    public function __construct(
        private IProventoRepository $proventoRepository,
    )
    {}

    public function execute(array $provento = []): array
    {
        $proventoDTO = new ProventoDTO($provento);
        $proventoDTO->user_uid = Auth::user()->uid;

        $proventoDTO->valor_total = $proventoDTO->valor * $proventoDTO->quantidade_ativo;

        // TODO: Pegar o preço medio para calcular yield_on_cost
        // $precoMedio = 95.00;
        // $custoDoAtivos = ($precoMedio * $proventoDTO->quantidade_ativo);
        // $proventoDTO->yield_on_cost = ($proventoDTO->valor_total / $custoDoAtivos) * 100;
        $proventoDTO->yield_on_cost = 0.0;

        return $this->proventoRepository->store($proventoDTO);
    }
}
