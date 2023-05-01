<?php

namespace App\Actions\Ativo;

use App\Interfaces\Repositories\IAtivoRepository;

class DeleteAction
{
    public function __construct(
        private IAtivoRepository $ativoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        return $this->ativoRepository->delete($uid);
    }
}
