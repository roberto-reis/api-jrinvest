<?php

namespace App\Interfaces\Repositories;

use App\DTOs\ClasseAtivo\ClasseAtivoDTO;

interface IClasseAtivoRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid): array;
    public function store(ClasseAtivoDTO $dto): array;
    public function exists(string $value, string $field = 'uid'): bool;
    public function update(string $uid, ClasseAtivoDTO $dto): array;
    public function delete(string $uid): bool;
}
