<?php

namespace App\Actions\RebalanceamentoAtivo;

use App\Exceptions\RebalanceamentoAtivoException;
use App\DTOs\Rebalanceamento\RebalanceamentoAtivoDTO;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $rebalanceamentoAtivoRepository,
    )
    {}

    public function execute(array $rebalanceamento = []): array
    {
        $dto = new RebalanceamentoAtivoDTO($rebalanceamento);
        $dto->user_uid = Auth::user()->uid;

        // Verificar soma do pecentual, não pode ser maior que 100.00
        $somaPecentualAtivo = $this->rebalanceamentoAtivoRepository->somaPecentual($dto->user_uid);
        $somaPecentualAtivo += $dto->percentual;
        if ($somaPecentualAtivo > 100) {
            throw new RebalanceamentoAtivoException('A soma dos percentuais não pode ser maior que 100.00%', 400);
        }

        return $this->rebalanceamentoAtivoRepository->store($dto);
    }
}
