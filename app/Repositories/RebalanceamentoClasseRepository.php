<?php

namespace App\Repositories;

use App\DTOs\Rebalanceamento\RebalanceamentoClasseDTO;
use App\Exceptions\RebalanceamentoClasseException;
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

    public function find(string $uid, array $with = []): array
    {
        $rebalanceamentoClasse = $this->model::with($with)->find($uid);

        if (!$rebalanceamentoClasse) throw new RebalanceamentoClasseException('Rebalanceamento por classe não encontrado', 404);

        return $rebalanceamentoClasse->toArray();
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function somaPecentual(string $data, string $campo = 'user_uid'): float
    {
        return $this->model::where($campo, $data)->sum('percentual');
    }

    public function somaPecentualUpdate(string $userUid, string $uid): float
    {
        return $this->model::where('user_uid', $userUid)->where('uid', '<>', $uid)->sum('percentual');
    }

    public function store(RebalanceamentoClasseDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function update(string $uid, RebalanceamentoClasseDTO $dto): array
    {
        $rebalanceamentoClasse = $this->model::find($uid);

        $rebalanceamentoClasse->update($dto->toArray());

        return $rebalanceamentoClasse->toArray();
    }

    public function delete(string $uid): bool
    {
        $rebalanceamentoClasse = $this->model::find($uid);

        if (!$rebalanceamentoClasse) {
            throw new RebalanceamentoClasseException('Rebalanceamento por classe não encontrado', 404);
        }

        return $rebalanceamentoClasse->delete();
    }
}
