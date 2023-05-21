<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginUserDto;
use App\Exceptions\LoginException;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IAuthRepository;

class LoginAction
{
    public function __construct(
        private IAuthRepository $authRepository
    )
    {}

    public function execute(array $data): array
    {
        $userDto = new LoginUserDto($data);

        if (!Auth::attempt($userDto->toArray())) {
            throw new LoginException("E-mail ou senha invalidos!", 401);
        }

        return create_token(Auth::user());
    }
}
