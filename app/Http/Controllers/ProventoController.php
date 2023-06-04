<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Exceptions\ProventoException;
use App\Actions\Provento\ListAllAction;
use App\Http\Requests\Provento\ListProventoRequest;

class ProventoController extends Controller
{
    public function listAll(ListProventoRequest $request, ListAllAction $listAll, $userUid): JsonResponse
    {
        try {
            $classesAtivos = $listAll->execute($userUid, $request->validated());

            return response_api('Dados retornados com sucesso', $classesAtivos);

        } catch (ProventoException $e) {
            return response_api( $e->getMessage(), [], $e->getCode());

        } catch (\Exception $e) {
            dd($e);
            send_log('Erro ao listar Proventos', [], 'error', $e);
            return response_api(
                'Erro ao listar Proventos',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    // public function show(ShowAction $showAction, string $uid): JsonResponse
    // {
    //     try {
    //         $classeAtivo = $showAction->execute($uid);

    //         return response_api('Dados retornados com sucesso', $classeAtivo);

    //     } catch (ClasseAtivoException $e) {
    //         return response_api($e->getMessage(), [], $e->getCode());

    //     } catch (\Exception $e) {
    //         send_log('Erro ao listar classe de ativo', [], 'error', $e);
    //         return response_api(
    //             'Erro ao listar classe de ativo',
    //             [],
    //             $e->getCode() == 0 ? 500 : $e->getCode()
    //         );
    //     }
    // }

    // public function store(StoreClasseAtivoRequest $request, StoreAction $storeAction): JsonResponse
    // {
    //     try {
    //         $classesAtivos = $storeAction->execute($request->validated());

    //         return response_api('Dados cadastrados com sucesso', $classesAtivos, 201);

    //     } catch (\Exception $e) {
    //         send_log('Erro ao cadastrar a classe de ativo', [], 'error', $e);
    //         return response_api(
    //             'Erro ao cadastrar a classe de ativo',
    //             [],
    //             $e->getCode() == 0 ? 500 : $e->getCode()
    //         );
    //     }
    // }

    // public function update(UpdateClasseAtivoRequest $request, UpdateAction $updateAction, $uid): JsonResponse
    // {
    //     try {
    //         $classesAtivos = $updateAction->execute($uid, $request->validated());

    //         return response_api('Dados Atualizados com sucesso', $classesAtivos, 200);

    //     } catch (ClasseAtivoException $e) {
    //         return response_api( $e->getMessage(), [], $e->getCode());

    //     } catch (\Exception $e) {
    //         send_log('Erro ao atualizar a classe de ativo', [], 'error', $e);
    //         return response_api(
    //             'Erro ao atualizar a classe de ativo',
    //             [],
    //             $e->getCode() == 0 ? 500 : $e->getCode()
    //         );
    //     }
    // }

    // public function delete(DeleteAction $deleteAction, $uid): JsonResponse
    // {
    //     try {
    //         $deleteAction->execute($uid);

    //         return response_api('Dados deletado com sucesso');

    //     } catch (ClasseAtivoException $e) {
    //         return response_api($e->getMessage(), [], $e->getCode());

    //     } catch (\Exception $e) {
    //         send_log('Erro ao deletar classe ativo', [], 'error', $e);
    //         return response_api(
    //             'Erro ao deletar classe ativo',
    //             [],
    //             $e->getCode() == 0 ? 500 : $e->getCode()
    //         );
    //     }
    // }
}
