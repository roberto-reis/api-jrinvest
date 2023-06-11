<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Provento\ProventoDTO;

interface IProventoRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid): array;
    public function store(ProventoDTO $dto): array;
    public function update(string $uid, ProventoDTO $dto): array;
    public function delete(string $uid): bool;
}
