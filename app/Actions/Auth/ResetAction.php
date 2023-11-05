<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Exceptions\AuthException;
use App\Models\PasswordResetToken;
use App\Interfaces\Repositories\IAuthRepository;
use Illuminate\Support\Facades\Hash;

class ResetAction
{
    //  Por padrão 30 minutos
    private int $tempoExpiracaoToken = env('TOKEN_EXPIRED_RESET_PASSWORD_AT', 30);

    public function __construct(
        private IAuthRepository $userRepository
    )
    {}

    public function execute(array $dados): bool
    {

        $passwordResetToken = PasswordResetToken::where('email', $dados['email'])
                                                ->where('token', $dados['token'])
                                                ->first();

        if (!$passwordResetToken) {
            throw new AuthException("Codigo invalido!", 400);
        }

        $createdAtValido = now()->parse($passwordResetToken->created_at)->addMinutes($this->tempoExpiracaoToken);

        if(now() > $createdAtValido) {
            throw new AuthException("Codigo expirado!", 422);
        }

        $user = User::query()->where('email', $dados['email'])->first();
        $user->password = Hash::make($dados['password']);
        $user->save();

        $user->tokens()->delete();
        $passwordResetToken->delete();

        return true;
    }
}
