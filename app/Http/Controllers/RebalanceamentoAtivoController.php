<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
            send_log('Erro ao listar todos rebalanceamento de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar todos rebalanceamento de ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }
}
