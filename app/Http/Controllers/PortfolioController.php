<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Portfolio\PosicaoAtualAction;
use App\Actions\Portfolio\PosicaoIdealAction;
use App\Actions\Portfolio\PosicaoAjusteAction;
use App\Actions\Portfolio\ListPortifolioAction;
use App\Http\Requests\Portfolio\PosicaoIdealRequest;
use App\Http\Requests\Portfolio\ListPortfolioRequest;
use App\Actions\Portfolio\RebalanceamentoPortifolioPorAtivoAction;

class PortfolioController extends Controller
{
    public function posicaoAtual(PosicaoAtualAction $action): JsonResponse
    {
        try {
            $portifolioAtual = $action->execute();
            return response_api('Dados retornados com sucesso', $portifolioAtual);

        } catch (\Exception $e) {
            send_log('Erro ao listar Posição Atual da carteira por ativo', [], 'error', $e);

            return response_api(
                $e->getMessage(),
            [],
            $e->getCode()
            );
        }
    }

    public function posicaoIdeal(PosicaoIdealAction $action): JsonResponse
    {
        try {
            $portifolioIdeal = $action->execute();
            return response_api('Dados retornados com sucesso', $portifolioIdeal);

        } catch (\Exception $e) {
            send_log('Erro ao listar Posição Ideal da carteira por ativo', [], 'error', $e);

            return response_api(
                $e->getMessage(),
            [],
            $e->getCode()
            );
        }
    }

    public function posicaoAjuste(PosicaoIdealRequest $request, PosicaoAjusteAction $action): JsonResponse
    {
        try {
            $portifolioAjuste = $action->execute();
            return response_api('Dados retornados com sucesso', $portifolioAjuste);

        } catch (\Exception $e) {
            send_log('Erro ao listar Ajuste de Posição da carteira por ativo', [], 'error', $e);

            return response_api(
                $e->getMessage(),
            [],
            $e->getCode()
            );
        }
    }

    // TODO: Implementar metodo posicaoAtualPorClasse
    // TODO: Implementar metodo posicaoAtualPorClasse
}
