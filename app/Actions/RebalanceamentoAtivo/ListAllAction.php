<?php

namespace App\Actions\RebalanceamentoAtivo;

use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class ListAllAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $repository
    )
    {}

    public function execute(array $filters = []): array
    {
        $rebalanceamentoAtivos = $this->repository->getAll($filters);
        return $rebalanceamentoAtivos;
    }
}
