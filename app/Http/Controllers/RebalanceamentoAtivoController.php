<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\RebalanceamentoAtivo\ShowAction;
use App\Actions\RebalanceamentoAtivo\StoreAction;
use App\Exceptions\RebalanceamentoAtivoException;
use App\Actions\RebalanceamentoAtivo\DeleteAction;
use App\Actions\RebalanceamentoAtivo\UpdateAction;
use App\Actions\RebalanceamentoAtivo\ListAllAction;
use App\Http\Requests\RebalanceamentoAtivo\ListRebalanceamentoAtivoRequest;
use App\Http\Requests\RebalanceamentoAtivo\StoreRebalanceamentoAtivoRequest;
use App\Http\Requests\RebalanceamentoAtivo\UpdateRebalanceamentoAtivoRequest;

class RebalanceamentoAtivoController extends Controller
{
    public function listAll(ListRebalanceamentoAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $rebalanceamentoAtivos = $listAll->execute($request->validated());

            return response_api('Dados retornados com sucesso', $rebalanceamentoAtivos, 200);

        } catch (\Exception $e) {
            send_log('Erro ao listar todos rebalanceamento por ativo', [], 'error', $e);

            return response_api(
                'Erro ao listar todos rebalanceamento por ativo',
                [],
                $e->getCode()
            );
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
            $e->getCode()
            );
        }
    }

    public function store(StoreRebalanceamentoAtivoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $rebalanceamentoAtivo = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso',$rebalanceamentoAtivo, 201);

        } catch (RebalanceamentoAtivoException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );

        } catch (\Exception $e) {
            dd($e);
            send_log('Erro ao cadastrar rebalanceamento por ativo', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar rebalanceamento por ativo',
                [],
                $e->getCode()
            );
        }
    }

    public function update(UpdateRebalanceamentoAtivoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $rebalanceamentoAtivo = $updateAction->execute($uid, $request->validated());

            return response_api('Dados Atualizados com sucesso', $rebalanceamentoAtivo);

        } catch (RebalanceamentoAtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao atualizar rebalanceamento por ativo', [], 'error', $e);
            return response_api(
                'Erro ao atualizar rebalanceamento por ativo',
                [],
                $e->getCode()
            );
        }
    }

    public function delete(DeleteAction $deleteAction, $uid): JsonResponse
    {
        try {
            $deleteAction->execute($uid);

            return response_api('Dados deletado com sucesso');

        } catch (RebalanceamentoAtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao deletar rebalanceamento por ativo', [], 'error', $e);

            return response_api(
                'Erro ao deletar rebalanceamento por ativo',
                [],
                $e->getCode()
            );
        }
    }
}
