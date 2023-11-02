<?php

namespace App\DTOs\Auth;

use App\DTOs\DataTransferObject;
use Illuminate\Support\Facades\Hash;

class UserDto extends DataTransferObject
{
    public ?string $name;
    public ?string $last_name;
    public ?string $phone;
    public ?string $email;
    public ?string $avatar;
    public ?string $password;

}
