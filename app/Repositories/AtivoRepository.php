<?php

namespace App\Repositories;

use App\Models\Ativo;
use App\DTOs\Ativo\AtivoDTO;
use App\Exceptions\AtivoException;
use App\Interfaces\Repositories\IAtivoRepository;

class AtivoRepository implements IAtivoRepository
{
    private Ativo $model;
    private int $perPage = 15;
    private array $allowedFields = ['codigo', 'nome', 'setor'];


    public function __construct()
    {
        $this->model = app(Ativo::class);
    }

    public function getAll(array $filters): array
    {
        $ativosQuery = $this->model::query()->with('classeAtivo');

        if (isset($filters['search'])) {
            foreach($this->allowedFields as $field) {
                $ativosQuery->orWhere($field, 'like', "%{$filters['search']}%");
            }
            // Buscar na tabela relacionamento
            $ativosQuery->orWhereHas('classeAtivo', function($query) use ($filters) {
                $query->where('nome', 'like', "%{$filters['search']}%");
            });
        }

        if (isset($filters['sort'])) {
            $ativosQuery->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $ativosQuery->get()->toArray();
        }

        return $ativosQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function store(AtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $value, $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function update(string $uid, AtivoDTO $dto): array
    {
        $ativo = $this->model::find($uid);

        if (!$ativo) {
            throw new AtivoException('Ativo não encontrado', 404);
        }

        $ativo->update($dto->toArray());

        return $ativo->toArray();
    }

    public function find(string $uid): array
    {
        $ativo = $this->model::find($uid);

        if (!$ativo) throw new AtivoException('Ativo não encontrado', 404);

        return $ativo->toArray();
    }

    public function delete(string $uid): bool
    {
        $ativo = $this->model::find($uid);

        if (!$ativo) {
            throw new AtivoException('Ativo não encontrado', 404);
        }

        return $ativo->delete();
    }
}
