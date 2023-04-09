<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Actions\ClasseAtivo\ListAllAction;
use App\Http\Requests\ClasseAtivo\ListClasseAtivoRequest;

class ClasseAtivoController extends Controller
{
    public function listAll(ListClasseAtivoRequest $request, ListAllAction $listAll)
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
}
