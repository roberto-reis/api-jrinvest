<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Rebalanceamento\RebalanceamentoClasseDTO;

interface IRebalanceamentoClasseRepository
{
    public function getAll(array $filters): array;
    public function find(string $uid, array $with = []): array;
    public function store(RebalanceamentoClasseDTO $dto): array;
    public function somaPecentual(string $data, string $campo = 'user_uid'): float;
    public function somaPecentualUpdate(string $userUid, string $uid): float;
    public function update(string $uid, RebalanceamentoClasseDTO $dto): array;
    public function exists(string $value, string $field = 'uid'): bool;
    public function delete(string $uid): bool;
}
