<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginUserDto;
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

        return $this->authRepository->login($userDto);
    }
}
