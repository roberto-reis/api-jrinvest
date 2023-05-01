<?php

namespace App\Actions\Ativo;

use App\DTOs\Ativo\AtivoDTO;
use App\Interfaces\Repositories\IAtivoRepository;

class UpdateAction
{
    public function __construct(
        private IAtivoRepository $classeAtivoRepository,
    )
    {}

    public function execute(string $uid, array $ativo = []): array
    {
        $ativoDto = new AtivoDTO($ativo);

        return $this->classeAtivoRepository->update($uid, $ativoDto->setCodigoStrtoupper());
    }
}
