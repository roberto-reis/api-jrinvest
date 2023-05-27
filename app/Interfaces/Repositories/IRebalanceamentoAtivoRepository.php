<?php

namespace App\Interfaces\Repositories;

interface IRebalanceamentoAtivoRepository
{
    public function getAll(array $filters): array;

}
