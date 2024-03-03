<?php

namespace App\Actions\RebalanceamentoClasse;

use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class ListAllAction
{
    public function __construct(
        private IRebalanceamentoClasseRepository $repository
    ){}

    public function execute(array $filters = []): array
    {
        $rebalanceamentoClasses = $this->repository->getAll($filters);
        return $rebalanceamentoClasses;
    }
}
