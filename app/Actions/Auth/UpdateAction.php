<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\UserDto;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Repositories\IAuthRepository;

class UpdateAction
{
    public function __construct(
        private IAuthRepository $userRepository
    )
    {}

    public function execute(string $uid, array $data): array
    {
        $userDto = new UserDto($data);

        if (!is_null($userDto->password)) {
            $userDto->password = Hash::make($userDto->password);
        }

        if (is_null($userDto->password)) {
            unset($userDto->password);
        }

        return $this->userRepository->update($uid, $userDto);
    }
}
