<?php

namespace App\Interfaces\Repositories;

interface IRebalanceamentoAtivoRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid, array $with = []): array;
}
