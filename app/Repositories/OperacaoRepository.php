<?php

namespace App\Repositories;

use App\Models\Operacao;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IOperacaoRepository;

class OperacaoRepository implements IOperacaoRepository
{
    private Operacao $model;
    private int $perPage = 15;
    private array $searchFields = ['cotacao_preco','quantidade','corretora','data_operacao','created_at'];
    private array $searchWith = [
        'user' => 'name',
        'ativo' => 'codigo',
        'tipoOperacao' => 'nome'
    ];

    public function __construct()
    {
        $this->model = app(Operacao::class);
    }

    public function getAll(array $filters): array
    {
        $withRelationship = array_keys($this->searchWith);
        $operacoes = $this->model::query()->with($withRelationship)
                                          ->where('user_uid', Auth::user()->uid);

        if (isset($filters['search']) && !empty($filters['search'])) {
            $operacoes->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }

                // Buscar nos relacionamentos
                foreach ($this->searchWith as $relationship => $field) {
                    $query->orWhereHas($relationship, function($query) use ($field, $filters) {
                        $query->where($field, 'like', "%{$filters['search']}%");
                    });
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
