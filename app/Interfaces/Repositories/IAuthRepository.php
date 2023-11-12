<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Auth\UserDto;

interface IAuthRepository
{
    public function store(UserDto $dto): array;
    public function exists(string $value, string $field = 'uid'): bool;
    public function update(string $uid, UserDto $dto): array;
    public function storePasswordResetToken(array $dados): array;
    public function deleteToken(string $email): bool;
    public function delete(string $userUid): bool;
}
