<?php

namespace App\Interfaces\Repositories;

interface IOperacaoRepository
{
    public function getAll(array $filters): array;
}
