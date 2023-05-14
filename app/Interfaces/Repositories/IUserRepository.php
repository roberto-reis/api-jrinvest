<?php

namespace App\Interfaces\Repositories;

use App\DTOs\User\RegisterUserDto;

interface IUserRepository
{
    public function store(RegisterUserDto $dto): array;
}
