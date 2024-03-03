<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Cotacao;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\ICotacaoRepository;

class CotacaoRepository implements ICotacaoRepository
{
    private Cotacao $model;

    public function __construct()
    {
        $this->model = app(Cotacao::class);
    }

    public function getAll(Carbon $data = null, $rangeDays = 3): Collection
    {
        $data = $data ?? now();
        $dataInicio = $data->copy()->subDays($rangeDays)->startOfDay()->toDateTimeString();
        $dataFim = $data->copy()->endOfDay()->toDateTimeString();

        $cotacoes = $this->model::query()
                            ->whereDate('created_at', '>=', $dataInicio)
                            ->whereDate('created_at', '<=', $dataFim)
                            ->orderBy('created_at', 'desc')->get();

        return $cotacoes;
    }

}
