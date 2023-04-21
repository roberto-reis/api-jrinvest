<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\ClasseAtivo\StoreAction;
use App\Actions\ClasseAtivo\ListAllAction;
use App\Http\Requests\ClasseAtivo\ListClasseAtivoRequest;
use App\Http\Requests\ClasseAtivo\StoreClasseAtivoRequest;

class ClasseAtivoController extends Controller
{
    public function listAll(ListClasseAtivoRequest $request, ListAllAction $listAll): JsonResponse
    {
        try {
            $classesAtivos = $listAll->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados retornados com sucesso',
                'data' => $classesAtivos
            ], 200);

        } catch (\Exception $e) {
            send_log('Erro ao listar as classes de ativos', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao listar as classes de ativos',
                'data' => []
            ], 500);
        }
    }

    public function store(StoreClasseAtivoRequest $request, StoreAction $storeAction): JsonResponse
    {
        try {
            $classesAtivos = $storeAction->execute($request->validated());

            return response()->json([
                'menssage' => 'Dados cadastrados com sucesso',
                'data' => $classesAtivos
            ], 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar a classe de ativo', [], 'error', $e);
            return response()->json([
                'menssage' => 'Erro ao cadastrar a classe de ativo',
                'data' => []
            ], 500);
        }
    }
}
