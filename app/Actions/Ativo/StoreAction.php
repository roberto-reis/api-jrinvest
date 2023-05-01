<?php

namespace App\Actions\Ativo;

use App\DTOs\Ativo\AtivoDTO;
use App\Interfaces\Repositories\IAtivoRepository;

class StoreAction
{
    public function __construct(
        private IAtivoRepository $ativoRepository,
    )
    {}

    public function execute(array $ativo = []): array
    {
        $ativoDto = new AtivoDTO($ativo);

        return $this->ativoRepository->store($ativoDto->setCodigoStrtoupper());
    }
}
