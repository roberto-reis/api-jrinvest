<?php

namespace App\Actions\Provento;

use App\DTOs\Provento\ProventoDTO;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IProventoRepository;

class UpdateAction
{
    public function __construct(
        private IProventoRepository $proventoRepository
    )
    {}

    public function execute(string $uid, array $provento = []): array
    {
        $proventoDTO = new ProventoDTO($provento);
        $proventoDTO->user_uid = Auth::user()->uid;

        $proventoDTO->valor_total = $proventoDTO->valor * $proventoDTO->quantidade_ativo;

        // TODO: Pegar o preço medio para calcular yield_on_cost
        // $precoMedio = 95.00;
        // $custoDoAtivos = ($precoMedio * $storeProventoDTO->quantidade_ativo);
        // $storeProventoDTO->yield_on_cost = ($storeProventoDTO->valor_total / $custoDoAtivos) * 100;
        $proventoDTO->yield_on_cost = 0.0;

        return $this->proventoRepository->update($uid, $proventoDTO);
    }
}
