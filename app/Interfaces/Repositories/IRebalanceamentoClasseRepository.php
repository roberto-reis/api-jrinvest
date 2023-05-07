<?php

namespace App\Interfaces\Repositories;

interface IRebalanceamentoClasseRepository
{
    public function getAll(array $filters): array;
}
