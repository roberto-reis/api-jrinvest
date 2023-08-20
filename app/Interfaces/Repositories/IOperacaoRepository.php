<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Operacao\OperacaoDTO;
use Illuminate\Support\Collection;

interface IOperacaoRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid): array;
    public function store(OperacaoDTO $dto): array;
    public function update(string $uid, OperacaoDTO $dto): array;
    public function delete(string $uid): bool;
    public function getAllByUser(string $userUid): Collection;
}
