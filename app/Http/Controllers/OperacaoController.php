<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Exceptions\OperacaoException;
use App\Actions\Operacao\ListAllAction;
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
            dd($e);
            send_log('Erro ao listar operações', [], 'error', $e);
            return response_api(
                'Erro ao listar operações',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }
}
