<?php

namespace App\Repositories;

use App\DTOs\User\RegisterUserDto;
use App\Interfaces\Repositories\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository
{
    private User $model;

    public function __construct()
    {
        $this->model = app(User::class);
    }

    public function store(RegisterUserDto $dto): array
    {
        $user = $this->model::create($dto->toArray());
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user->toArray(),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}
