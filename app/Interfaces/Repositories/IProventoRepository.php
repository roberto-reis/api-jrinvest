<?php

namespace App\Interfaces\Repositories;

interface IProventoRepository
{
    public function getAll(string $userUid, array $filters): array;
}
