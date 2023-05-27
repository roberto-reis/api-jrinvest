<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\RebalanceamentoAtivo\ShowAction;
use App\Exceptions\RebalanceamentoAtivoException;
use App\Actions\RebalanceamentoAtivo\ListAllAction;
use App\Http\Requests\RebalanceamentoAtivo\ListRebalanceamentoAtivoRequest;

class RebalanceamentoAtivoController extends Controller
{
    public function listAll(ListRebalanceamentoAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $rebalanceamentoAtivos = $listAll->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados retornados com sucesso',
                'data' => $rebalanceamentoAtivos
            ], 200);

        } catch (\Exception $e) {
            send_log('Erro ao listar todos rebalanceamento por ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar todos rebalanceamento por ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $rebalanceamentoAtivo = $showAction->execute($uid);

            return response_api('Dados retornados com sucesso', $rebalanceamentoAtivo);

        } catch (RebalanceamentoAtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar rebalanceamento por ativo', [], 'error', $e);

            return response_api(
            'Erro ao listar rebalanceamento por ativo',
            [],
            $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }
}
