<?php

namespace App\Repositories;

use App\Models\RebalanceamentoAtivo;
use App\Exceptions\RebalanceamentoAtivoException;
use App\DTOs\Rebalanceamento\RebalanceamentoAtivoDTO;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class RebalanceamentoAtivoRepository implements IRebalanceamentoAtivoRepository
{
    private RebalanceamentoAtivo $model;
    private int $perPage = 15;
    private array $searchFields = ['percentual', 'created_at'];
    private array $serachRelationships = [
        'user' => 'name',
        'ativo' => 'nome'
    ];


    public function __construct()
    {
        $this->model = app(RebalanceamentoAtivo::class);
    }

    public function getAll(array $filters): array
    {
        $rebalanceamentoQuery = $this->model::query()->with(['user', 'ativo']);

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

    public function find(string $uid, array $with = []): array
    {
        $rebalanceamentoClasse = $this->model::with($with)->find($uid);

        if (!$rebalanceamentoClasse) throw new RebalanceamentoAtivoException('Rebalanceamento por ativo não encontrado', 404);

        return $rebalanceamentoClasse->toArray();
    }

    public function somaPecentual(string $data, string $campo = 'user_uid'): float
    {
        return $this->model::where($campo, $data)->sum('percentual');
    }

    public function store(RebalanceamentoAtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function somaPecentualUpdate(string $userUid, string $uid): float
    {
        return $this->model::where('user_uid', $userUid)->where('uid', '<>', $uid)->sum('percentual');
    }

    public function update(string $uid, RebalanceamentoAtivoDTO $dto): array
    {
        $rebalanceamentoAtivo = $this->model::find($uid);

        $rebalanceamentoAtivo->update($dto->toArray());

        return $rebalanceamentoAtivo->toArray();
    }
}
