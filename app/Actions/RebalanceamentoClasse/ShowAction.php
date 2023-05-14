<?php

namespace App\Actions\RebalanceamentoClasse;

use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class ShowAction
{
    public function __construct(
        private IRebalanceamentoClasseRepository $repository
    )
    {}

    public function execute(string $uid): array
    {
        $rebalanceamentoClasses = $this->repository->find($uid, ['user', 'classeAtivo']);
        return $rebalanceamentoClasses;
    }
}
