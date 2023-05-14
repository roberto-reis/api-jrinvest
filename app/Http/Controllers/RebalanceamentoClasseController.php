<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\RebalanceamentoClasse\ShowAction;
use App\Actions\RebalanceamentoClasse\StoreAction;
use App\Exceptions\RebalanceamentoClasseException;
use App\Actions\RebalanceamentoClasse\ListAllAction;
use App\Http\Requests\RebalanceamentoClasse\StoreRebalanceamentoRequest;
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
            send_log('Erro ao listar todos rebalanceamento classe de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar todos rebalanceamento classe de ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $rebalanceamentoClasse = $showAction->execute($uid);

            return response()->json([
                'menssage' => 'Dados retornados com sucesso',
                'data' => $rebalanceamentoClasse
            ], 200);

        } catch (RebalanceamentoClasseException $e) {
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        } catch (\Exception $e) {
            send_log('Erro ao listar rebalanceamento classe de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar rebalanceamento classe de ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function store(StoreRebalanceamentoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $classesAtivos = $storeAction->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados cadastrados com sucesso',
                'data' => $classesAtivos
            ], 201);

        } catch (RebalanceamentoClasseException $e) {
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        } catch (\Exception $e) {
            send_log('Erro ao cadastrar rebalanceamento classe de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao cadastrar rebalanceamento classe de ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    // TODO: Implementar metodo Update
    // TODO: Implementar metodo delete
}
