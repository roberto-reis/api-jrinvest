<?php

namespace App\Actions\RebalanceamentoClasse;

use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class DeleteAction
{
    public function __construct(
        private IRebalanceamentoClasseRepository $rebalanceamentoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        return $this->rebalanceamentoRepository->delete($uid);
    }
}
