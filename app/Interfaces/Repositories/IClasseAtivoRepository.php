<?php

namespace App\Interfaces\Repositories;

use App\DTOs\ClasseAtivo\StoreClasseAtivoDTO;

interface IClasseAtivoRepository
{
    public function getAll(array $filters): array;
    public function store(StoreClasseAtivoDTO $dto): array;
}
