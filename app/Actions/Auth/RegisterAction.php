<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\UserDto;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Repositories\IAuthRepository;

class RegisterAction
{
    public function __construct(
        private IAuthRepository $userRepository
    )
    {}

    public function execute(array $data): array
    {
        $userDto = new UserDto($data);

        $userDto->password = Hash::make($userDto->password);

        return $this->userRepository->store($userDto);
    }
}
