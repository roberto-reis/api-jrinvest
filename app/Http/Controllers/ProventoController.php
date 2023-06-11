<?php

namespace App\Http\Controllers;

use App\Models\Provento;
use Illuminate\Http\JsonResponse;
use App\Actions\Provento\ShowAction;
use App\Actions\Provento\StoreAction;
use App\Exceptions\ProventoException;
use App\Actions\Provento\DeleteAction;
use App\Actions\Provento\UpdateAction;
use App\Actions\Provento\ListAllAction;
use App\Http\Requests\Provento\ListProventoRequest;
use App\Http\Requests\Provento\StoreProventoRequest;
use App\Http\Requests\Provento\UpdateProventoRequest;

class ProventoController extends Controller
{
    public function listAll(ListProventoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $classesAtivos = $listAll->execute($request->validated());

            return response_api('Dados retornados com sucesso', $classesAtivos);

        } catch (ProventoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar todos Proventos', [], 'error', $e);
            return response_api(
                'Erro ao listar Proventos',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $provento = $showAction->execute($uid);

            return response_api('Dados retornados com sucesso', $provento);

        } catch (ProventoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao listar Provento', [], 'error', $e);
            return response_api(
                'Erro ao listar Provento',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function store(StoreProventoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $provento = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso', $provento, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar provento', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar provento',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function update(UpdateProventoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $provento = $updateAction->execute($uid, $request->validated());

            return response_api('Dados Atualizados com sucesso', $provento, 200);

        } catch (ProventoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao atualizar provento', [], 'error', $e);
            return response_api(
                'Erro ao atualizar provento',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function delete(DeleteAction $deleteAction, $uid): JsonResponse
    {
        try {
            $deleteAction->execute($uid);

            return response_api('Dados deletado com sucesso');

        } catch (ProventoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao deletar provento', [], 'error', $e);
            return response_api(
                'Erro ao deletar provento',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }
}
