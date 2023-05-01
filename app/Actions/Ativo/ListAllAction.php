<?php

namespace App\Actions\Ativo;

use App\Interfaces\Repositories\IAtivoRepository;

class ListAllAction
{
    public function __construct(
        private IAtivoRepository $classeAtivoRepository
    )
    {}

    public function execute(array $filters = []): array
    {
        $classesAtivos = $this->classeAtivoRepository->getAll($filters);
        return $classesAtivos;
    }
}
