<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\RegisterUserDto;
use App\Interfaces\Repositories\IAuthRepository;

class RegisterAction
{
    public function __construct(
        private IAuthRepository $userRepository
    )
    {}

    public function execute(array $data): array
    {
        $userDto = new RegisterUserDto($data);

        return $this->userRepository->store($userDto->withMakeHash());
    }
}
