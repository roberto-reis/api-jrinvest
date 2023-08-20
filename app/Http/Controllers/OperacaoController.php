<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Operacao\ShowAction;
use App\Actions\Operacao\StoreAction;
use App\Exceptions\OperacaoException;
use App\Actions\Operacao\DeleteAction;
use App\Actions\Operacao\UpdateAction;
use App\Actions\Operacao\ListAllAction;
use App\Http\Requests\Operacao\OperacaoRequest;
use App\Http\Requests\Operacao\ListOperacoesRequest;

class OperacaoController extends Controller
{
    public function listAll(ListOperacoesRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $operacoes = $listAll->execute($request->validated());
            return response_api('Dados retornados com sucesso', $operacoes);

        } catch (OperacaoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar operações', [], 'error', $e);
            return response_api(
                'Erro ao listar operações',
                [],
                $e->getCode()
            );
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $operacao = $showAction->execute($uid);

            return response_api('Dados retornados com sucesso', $operacao);

        } catch (OperacaoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar Operação', [], 'error', $e);
            return response_api(
                'Erro ao listar Operação',
                [],
                $e->getCode()
            );
        }
    }

    public function store(OperacaoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $operacao = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso', $operacao, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar operação', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar operação',
                [],
                $e->getCode()
            );
        }
    }

    public function update(OperacaoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $operacao = $updateAction->execute($uid, $request->validated());

            return response_api('Dados Atualizados com sucesso', $operacao, 200);

        } catch (OperacaoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao atualizar operação', [], 'error', $e);
            return response_api(
                'Erro ao atualizar operação',
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

        } catch (OperacaoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao deletar operação', [], 'error', $e);
            return response_api(
                'Erro ao deletar operação',
                [],
                $e->getCode()
            );
        }
    }
}
