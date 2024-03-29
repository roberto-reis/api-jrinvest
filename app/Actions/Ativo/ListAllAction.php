<?php

namespace App\Actions\Ativo;

use App\Interfaces\Repositories\IAtivoRepository;

class ListAllAction
{
    public function __construct(
        private IAtivoRepository $ativoRepository
    )
    {}

    public function execute(array $filters = []): array
    {
        $ativos = $this->ativoRepository->getAll($filters);
        return $ativos;
    }
}
