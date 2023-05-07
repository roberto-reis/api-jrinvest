<?php

namespace App\Interfaces\Repositories;

interface IRebalanceamentoClasseRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid, array $with = []): array;
}
