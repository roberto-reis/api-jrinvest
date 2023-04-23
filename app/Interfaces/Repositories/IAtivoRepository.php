<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Ativo\AtivoDTO;

interface IAtivoRepository
{
    public function getAll(array $filters): array;
    public function store(AtivoDTO $dto): array;
    public function exists(string $uid): bool;
    public function update(string $uid, AtivoDTO $dto): array;
}
