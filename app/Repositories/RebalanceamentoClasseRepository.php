<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;
use App\Models\RebalanceamentoClasse;

class RebalanceamentoClasseRepository implements IRebalanceamentoClasseRepository
{
    private RebalanceamentoClasse $model;
    private int $perPage = 15;
    private array $searchFields = ['percentual', 'created_at'];
    private array $serachRelationships = [
        'user' => 'name',
        'classeAtivo' => 'nome'
    ];


    public function __construct()
    {
        $this->model = app(RebalanceamentoClasse::class);
    }

    public function getAll(array $filters): array
    {
        $rebalanceamentoQuery = $this->model::query()->with(['user', 'classeAtivo']);

        if (isset($filters['search'])) {
            foreach($this->searchFields as $field) {
                $rebalanceamentoQuery->orWhere($field, 'like', "%{$filters['search']}%");
            }

            // Buscar na tabela relacionamento
            foreach ($this->serachRelationships as $key => $field) {
                $rebalanceamentoQuery->orWhereHas($key, function($query) use ($field, $filters) {
                    $query->where($field, 'like', "%{$filters['search']}%");
                });
            }
        }

        if (isset($filters['sort'])) {
            $rebalanceamentoQuery->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['with_paginate']) && !(bool)$filters['with_paginate']) {
            return $rebalanceamentoQuery->get()->toArray();
        }

        return $rebalanceamentoQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }
}
