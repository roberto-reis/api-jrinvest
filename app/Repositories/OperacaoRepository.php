<?php

namespace App\Repositories;

use App\Models\Operacao;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IOperacaoRepository;

class OperacaoRepository implements IOperacaoRepository
{
    private Operacao $model;
    private int $perPage = 15;
    private array $searchFields = [
        'cotacao_preco',
        'quantidade',
        'corretora',
        'data_operacao',
        'operacoes.created_at',
        'users.name',
        'ativos.codigo',
        'tipos_operacoes.nome'
    ];

    public function __construct()
    {
        $this->model = app(Operacao::class);
    }

    public function getAll(array $filters): array
    {
        $operacoes = $this->model::query()
                            ->select([
                                'operacoes.*',
                                'users.name as user_name',
                                'ativos.codigo as codigo_ativo',
                                'tipos_operacoes.nome as tipo_operacao'
                            ])
                            ->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid')
                            ->join('users', 'operacoes.user_uid', '=', 'users.uid')
                            ->join('ativos', 'operacoes.ativo_uid', '=', 'ativos.uid')
                            ->where('user_uid', Auth::user()->uid);

        if (isset($filters['search']) && !empty($filters['search'])) {
            $operacoes->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }
            });
        }

        if (isset($filters['sort']) && isset($filters['direction'])) {
            $operacoes->orderBy($filters['sort'], $filters['direction']);
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $operacoes->get()->toArray();
        }

        return $operacoes->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }
}
