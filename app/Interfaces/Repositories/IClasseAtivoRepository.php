<?php

namespace App\Interfaces\Repositories;

interface IClasseAtivoRepository
{
    public function getAll(array $filters): array;
}
