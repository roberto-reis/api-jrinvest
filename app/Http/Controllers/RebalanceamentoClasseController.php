<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\RebalanceamentoClasse\ListAllAction;
use App\Http\Requests\RebalanceamentoClasse\ListRebalanceamentoClasseRequest;

class RebalanceamentoClasseController extends Controller
{
    public function listAll(ListRebalanceamentoClasseRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $rebalanceamentoClasse = $listAll->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados retornados com sucesso',
                'data' => $rebalanceamentoClasse
            ], 200);

        } catch (\Exception $e) {
            send_log('Erro ao listar Rebalanceamento Classe de Ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar Rebalanceamento Classe de Ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }
}
