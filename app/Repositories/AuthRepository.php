<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\Auth\RegisterUserDto;
use App\Interfaces\Repositories\IAuthRepository;

class AuthRepository implements IAuthRepository
{
    private User $model;

    public function __construct()
    {
        $this->model = app(User::class);
    }

    public function store(RegisterUserDto $dto): array
    {
        $user = $this->model::create($dto->toArray());

        return create_token($user);
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }
}
