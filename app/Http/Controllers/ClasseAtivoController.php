<?php

namespace App\Http\Controllers;

use App\Actions\ClasseAtivo\ListAllAction;
use Illuminate\Http\Request;

class ClasseAtivoController extends Controller
{
    public function listAll(Request $request, ListAllAction $listAll)
    {
        // TODO: Falta implementar os filtros de busca
        $classesAtivos = $listAll->execute();

        return response()->json([
            'menssage' => 'Dados retornados com sucesso',
            'data' => $classesAtivos
        ], 200);
    }
}
