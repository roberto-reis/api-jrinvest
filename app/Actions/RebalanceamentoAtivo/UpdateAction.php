<?php

namespace App\Actions\RebalanceamentoAtivo;

use App\Exceptions\RebalanceamentoAtivoException;
use App\DTOs\Rebalanceamento\RebalanceamentoAtivoDTO;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;
use Illuminate\Support\Facades\Auth;

class UpdateAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $rebalanceamentoRepository,
    )
    {}

    public function execute(string $uid, array $rebalanceamento = []): array
    {
        $dto = new RebalanceamentoAtivoDTO($rebalanceamento);
        $dto->user_uid = Auth::user()->uid;

        if (!$this->rebalanceamentoRepository->exists($uid)) {
            throw new RebalanceamentoAtivoException('Rebalanceamento por ativo não encontrado', 404);
        }

        // Verificar soma do pecentual, não pode ser maior que 100.00
        $somaPecentualAtivo = $this->rebalanceamentoRepository->somaPecentualUpdate($dto->user_uid, $uid);
        $somaPecentualAtivo += $dto->percentual;
        if ($somaPecentualAtivo > 100) {
            throw new RebalanceamentoAtivoException('A soma dos percentuais não pode ser maior que 100.00%', 400);
        }

        return $this->rebalanceamentoRepository->update($uid, $dto);
    }
}
