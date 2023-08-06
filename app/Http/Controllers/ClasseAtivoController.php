<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\ClasseAtivo\ShowAction;
use App\Actions\ClasseAtivo\StoreAction;
use App\Exceptions\ClasseAtivoException;
use App\Actions\ClasseAtivo\DeleteAction;
use App\Actions\ClasseAtivo\UpdateAction;
use App\Actions\ClasseAtivo\ListAllAction;
use App\Http\Requests\ClasseAtivo\ListClasseAtivoRequest;
use App\Http\Requests\ClasseAtivo\StoreClasseAtivoRequest;
use App\Http\Requests\ClasseAtivo\UpdateClasseAtivoRequest;

class ClasseAtivoController extends Controller
{
    public function listAll(ListClasseAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $classesAtivos = $listAll->execute($request->validated());

            return response_api('Dados retornados com sucesso', $classesAtivos);

        } catch (\Exception $e) {
            send_log('Erro ao listar as classes de ativos', [], 'error', $e);
            return response_api(
                'Erro ao listar as classes de ativos',
                [],
                $e->getCode()
            );
        }
    }

    public function show(ShowAction $showAction, string $uid): JsonResponse
    {
        try {
            $classeAtivo = $showAction->execute($uid);

            return response_api('Dados retornados com sucesso', $classeAtivo);

        } catch (ClasseAtivoException $e) {
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

    public function store(StoreClasseAtivoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $classesAtivos = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso', $classesAtivos, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar a classe de ativo', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar a classe de ativo',
                [],
                $e->getCode()
            );
        }
    }

    public function update(UpdateClasseAtivoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $classesAtivos = $updateAction->execute($uid, $request->validated());

            return response_api('Dados Atualizados com sucesso', $classesAtivos, 200);

        } catch (ClasseAtivoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao atualizar a classe de ativo', [], 'error', $e);
            return response_api(
                'Erro ao atualizar a classe de ativo',
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

        } catch (ClasseAtivoException $e) {
            return response_api($e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            send_log('Erro ao deletar classe ativo', [], 'error', $e);
            return response_api(
                'Erro ao deletar classe ativo',
                [],
                $e->getCode()
            );
        }
    }
}
