<?php

namespace App\Http\Controllers;

use App\Actions\Ativo\ShowAction;
use Illuminate\Http\JsonResponse;
use App\Actions\Ativo\StoreAction;
use App\Exceptions\AtivoException;
use App\Actions\Ativo\DeleteAction;
use App\Actions\Ativo\UpdateAction;
use App\Actions\Ativo\ListAllAction;
use App\Http\Requests\Ativo\AtivoRequest;
use App\Http\Requests\Ativo\ListAtivoRequest;

class AtivoController extends Controller
{
    public function listAll(ListAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $ativos = $listAll->execute($request->validated());

            return response_api('Dados retornados com sucesso', $ativos);

        } catch (\Exception $e) {
            send_log('Erro ao listar ativos', [], 'error', $e);
            return response_api('Erro ao listar ativos', [], $e->getCode());
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $ativo = $showAction->execute($uid);

            return response_api('Dados retornados com sucesso', $ativo);

        } catch (AtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar classe de ativo', [], 'error', $e);
            return response_api(
                'Erro ao listar classe de ativo',
                [],
                $e->getCode()
            );
        }
    }

    public function store(AtivoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $ativo = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso', $ativo, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar a classe de ativo', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar a classe de ativo',
                [],
                $e->getCode()
            );
        }
    }

    public function update(AtivoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $classesAtivos = $updateAction->execute($uid, $request->validated());

            return response_api('Dados Atualizados com sucesso', $classesAtivos);

        } catch (AtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao atualizar ativo', [], 'error', $e);
            return response_api(
                'Erro ao atualizar ativo',
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

        } catch (AtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao deletar ativo', [], 'error', $e);
            return response_api(
                'Erro ao deletar ativo',
                [],
                $e->getCode()
            );
        }
    }
}
