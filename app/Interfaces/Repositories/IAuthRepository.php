<?php

namespace App\Interfaces\Repositories;

use App\DTOs\Auth\LoginUserDto;
use App\DTOs\Auth\RegisterUserDto;


interface IAuthRepository
{
    public function store(RegisterUserDto $dto): array;
    public function login(LoginUserDto $userDto): array;
}
