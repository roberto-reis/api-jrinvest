<?php

namespace App\Repositories;

use App\Models\ClasseAtivo;
use App\DTOs\ClasseAtivo\ClasseAtivoDTO;
use App\Exceptions\ClasseAtivoException;
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

        if (isset($filters['sort'])) {
            $classesQuery->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $classesQuery->get()->toArray();
        }

        return $classesQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function store(ClasseAtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function update(string $uid, ClasseAtivoDTO $dto): array
    {
        $classeAtivo = $this->model::find($uid);

        if (!$classeAtivo) {
            throw new ClasseAtivoException('Classe de ativo não encontrado', 404);
        }

        $classeAtivo->update($dto->toArray());

        return $classeAtivo->toArray();
    }

    public function find(string $uid): array
    {
        $classeAtivo = $this->model::find($uid);

        if (!$classeAtivo) throw new ClasseAtivoException('Classe de ativo não encontrado', 404);

        return $classeAtivo->toArray();
    }

    public function delete(string $uid): bool
    {
        $classeAtivo = $this->model::find($uid);

        if (!$classeAtivo) throw new ClasseAtivoException('Classe de ativo não encontrado', 404);

        if ($classeAtivo->ativos()->exists()) {
            throw new ClasseAtivoException('Não será possivel deletar, existe ativo ultilizando essa classe', 400);
        }

        return $classeAtivo->delete();
    }
}
