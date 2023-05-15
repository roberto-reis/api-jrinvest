<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\Auth\LoginUserDto;
use App\DTOs\Auth\RegisterUserDto;
use App\Exceptions\LoginException;
use Illuminate\Support\Facades\Auth;
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
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user->toArray(),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    public function login(LoginUserDto $userDto): array
    {
        if (!Auth::attempt($userDto->toArray())) {
            throw new LoginException("E-mail ou senha invalidos!", 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user->toArray(),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}
