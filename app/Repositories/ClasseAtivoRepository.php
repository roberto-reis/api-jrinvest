<?php

namespace App\Repositories;

use App\Models\ClasseAtivo;
use App\DTOs\ClasseAtivo\ClasseAtivoDTO;
use App\Exceptions\ClasseAtivoNaoEncontradoException;
use App\Interfaces\Repositories\IClasseAtivoRepository;

class ClasseAtivoRepository implements IClasseAtivoRepository
{
    private ClasseAtivo $model;
    private int $perPage = 15;
    private array $allowedFields = ['nome_interno', 'descricao'];

    public function __construct()
    {
        $this->model = app(ClasseAtivo::class);
    }

    public function getAll(array $filters): array
    {
        $classesQuery = $this->model::query();

        if (isset($filters['search'])) {
            foreach($this->allowedFields as $field) {
                $classesQuery->orWhere($field, 'like', "%{$filters['search']}%");
            }
        }

        if (isset($filters['sort']) && isset($filters['direction'])) {
            $classesQuery->orderBy($filters['sort'], $filters['direction']);
        }

        return $classesQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function store(ClasseAtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $uid): bool
    {
        return $this->model::where('uid', $uid)->exists();
    }

    public function update(string $uid, ClasseAtivoDTO $dto): array
    {
        $classeAtivo = $this->model::find($uid);

        if (!$classeAtivo) {
            throw new ClasseAtivoNaoEncontradoException();
        }

        $classeAtivo->update($dto->toArray());

        return $classeAtivo->toArray();
    }
}
