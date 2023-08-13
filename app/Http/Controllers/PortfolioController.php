<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Portfolio\ListAllAction;
use App\Http\Requests\Portfolio\ListPortfolioRequest;

class PortfolioController extends Controller
{
    public function listAll(ListPortfolioRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $portfolio = $listAll->execute($request->validated());
            return response_api('Dados retornados com sucesso', $portfolio);

        } catch (\Exception $e) {
            send_log('Erro ao listar operações', [], 'error', $e);
            return response_api(
                'Erro ao listar operações',
                [],
                $e->getCode()
            );
        }
    }

}
