<?php

namespace App\Actions\ClasseAtivo;

use App\Interfaces\Repositories\IClasseAtivoRepository;

class ListAllAction
{
    public function __construct(
        private IClasseAtivoRepository $classeAtivoRepository
    )
    {}

    public function execute(array $filters = []): array
    {
        $classesAtivos = $this->classeAtivoRepository->getAll($filters);
        return $classesAtivos;
    }
}
