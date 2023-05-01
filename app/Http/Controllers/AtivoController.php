<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Ativo\StoreAction;
use App\Actions\Ativo\DeleteAction;
use App\Actions\Ativo\UpdateAction;
use App\Actions\Ativo\ListAllAction;
use App\Http\Requests\Ativo\AtivoRequest;
use App\Http\Requests\Ativo\ListAtivoRequest;
use App\Exceptions\AtivoNaoEncontradoException;

class AtivoController extends Controller
{
    public function listAll(ListAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $ativos = $listAll->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados retornados com sucesso',
                'data' => $ativos
            ], 200);

        } catch (\Exception $e) {
            send_log('Erro ao listar ativos', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar ativos',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function store(AtivoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $ativo = $storeAction->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados cadastrados com sucesso',
                'data' => $ativo
            ], 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar a classe de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao cadastrar a classe de ativo',
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function update(AtivoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    {
        try {
            $classesAtivos = $updateAction->execute($uid, $request->validated());

            return response()->json([
                'menssage' => 'Dados Atualizados com sucesso',
                'data' => $classesAtivos
            ], 200);

        } catch (AtivoNaoEncontradoException $e) {
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        } catch (\Exception $e) {
            send_log('Erro ao atualizar ativo', [], 'error', $e);
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }

    public function delete(DeleteAction $deleteAction, $uid): JsonResponse
    {
        try {
            $deleteAction->execute($uid);

            return response()->json([
                'menssage' => 'Dados deletado com sucesso',
                'data' => []
            ], 200);

        } catch (AtivoNaoEncontradoException $e) {
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        } catch (\Exception $e) {
            send_log('Erro ao deletar ativo', [], 'error', $e);
            return response()->json([
                'menssage' => $e->getMessage(),
                'data' => []
            ], $e->getCode() == 0 ? 500 : $e->getCode());
        }
    }
}
