<?php

namespace App\DTOs\Auth;

use App\DTOs\DataTransferObject;

class LoginUserDto extends DataTransferObject
{
    public ?string $email;
    public ?string $password;

}
