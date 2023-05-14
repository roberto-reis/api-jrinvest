<?php

namespace App\Actions\Auth;

use App\DTOs\User\RegisterUserDto;
use App\Interfaces\Repositories\IUserRepository;

class RegisterAction
{
    public function __construct(
        private IUserRepository $userRepository
    )
    {}

    public function execute(array $data): array
    {
        $userDto = new RegisterUserDto($data);

        return $this->userRepository->store($userDto);
    }
}
