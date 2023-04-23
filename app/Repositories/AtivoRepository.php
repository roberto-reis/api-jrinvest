<?php

namespace App\Repositories;

use App\Models\Ativo;
use App\DTOs\Ativo\AtivoDTO;
use App\Exceptions\AtivoNaoEncontradoException;
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

        if (isset($filters['sort']) && isset($filters['direction'])) {
            $ativosQuery->orderBy($filters['sort'], $filters['direction']);
        }

        return $ativosQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function store(AtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $uid): bool
    {
        return $this->model::where('uid', $uid)->exists();
    }

    public function update(string $uid, AtivoDTO $dto): array
    {
        $classeAtivo = $this->model::find($uid);

        if (!$classeAtivo) {
            throw new AtivoNaoEncontradoException();
        }

        $classeAtivo->update($dto->toArray());

        return $classeAtivo->toArray();
    }
}
