<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Operacao\ShowAction;
use App\Actions\Operacao\StoreAction;
use App\Exceptions\OperacaoException;
use App\Actions\Operacao\ListAllAction;
use App\Http\Requests\Operacao\ListOperacoesRequest;
use App\Http\Requests\Operacao\StoreOperacaoRequest;

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
                $e->getCode() == 0 ? 500 : $e->getCode()
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
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function store(StoreOperacaoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $operacao = $storeAction->execute($request->validated());

            return response_api('Dados cadastrados com sucesso', $operacao, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar operação', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar operação',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }
}
