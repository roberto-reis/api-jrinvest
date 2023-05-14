<?php

namespace App\Actions\RebalanceamentoClasse;

use App\DTOs\Rebalanceamento\RebalanceamentoClasseDTO;
use App\Exceptions\RebalanceamentoClasseException;
use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class UpdateAction
{
    public function __construct(
        private IRebalanceamentoClasseRepository $rebalanceamentoRepository,
    )
    {}

    public function execute(string $uid, array $rebalanceamento = []): array
    {
        $dto = new RebalanceamentoClasseDTO($rebalanceamento);

        if (!$this->rebalanceamentoRepository->exists($uid)) {
            throw new RebalanceamentoClasseException('Rebalanceamento por classe não encontrado', 404);
        }

        // Verificar soma do pecentual, não pode ser maior que 100.00
        $somaPecentualClasse = $this->rebalanceamentoRepository->somaPecentualUpdate($dto->user_uid, $uid);
        $somaPecentualClasse += $dto->percentual;
        if ($somaPecentualClasse > 100) {
            throw new RebalanceamentoClasseException('A soma dos percentuais não pode ser maior que 100.00%', 400);
        }

        return $this->rebalanceamentoRepository->update($uid, $dto);
    }
}
