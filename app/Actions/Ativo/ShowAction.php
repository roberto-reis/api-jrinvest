<?php

namespace App\Actions\Ativo;

use App\Interfaces\Repositories\IAtivoRepository;

class ShowAction
{
    public function __construct(
        private IAtivoRepository $ativoRepository
    )
    {}

    public function execute(string $uid): array
    {
        $ativo = $this->ativoRepository->find($uid);
        return $ativo;
    }
}
