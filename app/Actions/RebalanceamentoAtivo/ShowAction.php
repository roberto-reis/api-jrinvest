<?php

namespace App\Actions\RebalanceamentoAtivo;

use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class ShowAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $repository
    )
    {}

    public function execute(string $uid): array
    {
        $rebalanceamentoClasses = $this->repository->find($uid, ['user', 'ativo']);
        return $rebalanceamentoClasses;
    }
}
