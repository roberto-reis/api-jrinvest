<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Provento\StoreProventoDTO;

interface IProventoRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid, string $userUid): array;
    public function store(StoreProventoDTO $dto): array;
}
