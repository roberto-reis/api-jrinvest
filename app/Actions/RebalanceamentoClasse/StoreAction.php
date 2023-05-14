<?php

namespace App\Actions\RebalanceamentoClasse;

use App\DTOs\Rebalanceamento\RebalanceamentoClasseDTO;
use App\Exceptions\RebalanceamentoClasseException;
use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class StoreAction
{
    public function __construct(
        private IRebalanceamentoClasseRepository $rebalanceamentoClasseRepository,
    )
    {}

    public function execute(array $rebalanceamento = []): array
    {
        $dto = new RebalanceamentoClasseDTO($rebalanceamento);

        // Verificar soma do pecentual, não pode ser maior que 100.00
        $somaPecentualClasse = $this->rebalanceamentoClasseRepository->somaPecentual($dto->user_uid);
        $somaPecentualClasse += $dto->percentual;
        if ($somaPecentualClasse > 100) {
            throw new RebalanceamentoClasseException('A soma dos percentuais não pode ser maior que 100.00%', 400);
        }

        return $this->rebalanceamentoClasseRepository->store($dto);
    }
}
