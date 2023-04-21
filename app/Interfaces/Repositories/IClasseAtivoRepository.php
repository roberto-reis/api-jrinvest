<?php

namespace App\Interfaces\Repositories;

use App\DTOs\ClasseAtivo\StoreClasseAtvioDTO;

interface IClasseAtivoRepository
{
    public function getAll(array $filters): array;
    public function store(StoreClasseAtvioDTO $dto): array;
}
