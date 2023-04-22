<?php

namespace App\Interfaces\Repositories;

use App\DTOs\ClasseAtivo\ClasseAtivoDTO;

interface IClasseAtivoRepository
{
    public function getAll(array $filters): array;
    public function store(ClasseAtivoDTO $dto): array;
    public function exists(string $uid): bool;
    public function update(string $uid, ClasseAtivoDTO $dto): array;
}
