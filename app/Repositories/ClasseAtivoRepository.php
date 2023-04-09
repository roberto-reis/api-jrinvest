<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IClasseAtivoRepository;
use App\Models\ClasseAtivo;

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
}
