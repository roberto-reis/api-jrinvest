<?php

namespace App\Actions\RebalanceamentoAtivo;

use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class DeleteAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $rebalanceamentoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        return $this->rebalanceamentoRepository->delete($uid);
    }
}
