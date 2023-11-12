<?php

namespace App\Actions\Auth;

use App\Interfaces\Repositories\IAuthRepository;
use App\Mail\Auth\SendTokenResetPassword;
use Illuminate\Support\Facades\Mail;

class ForgotAction
{
    public function __construct(
        private IAuthRepository $userRepository
    )
    {}

    public function execute(string $email): bool
    {
        $resetToken = str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);

        $this->userRepository->deleteToken($email);

        $passwordReset = $this->userRepository->storePasswordResetToken([
            'email' => $email,
            'token' => $resetToken,
            'created_at' => now()
        ]);

        // TODO: Fazer template do e-mail
        Mail::to($email)->send(new SendTokenResetPassword($passwordReset));

        return true;
    }
}
