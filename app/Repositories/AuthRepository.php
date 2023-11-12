<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\Auth\UserDto;
use App\Exceptions\AuthException;
use App\Models\PasswordResetToken;
use App\Interfaces\Repositories\IAuthRepository;

class AuthRepository implements IAuthRepository
{
    private User $model;

    public function __construct()
    {
        $this->model = app(User::class);
    }

    public function store(UserDto $dto): array
    {
        $user = $this->model::create($dto->toArray());

        return create_token($user);
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function update(string $uid, UserDto $dto): array
    {
        $user = $this->model::find($uid);

        if (!$user) {
            throw new AuthException('User não encontrado', 404);
        }

        $user->update($dto->toArray());

        return $user->toArray();
    }

    public function storePasswordResetToken(array $dados): array
    {
        $passwordResetToken = PasswordResetToken::create($dados);

        return $passwordResetToken->toArray();
    }

    public function deleteToken(string $email): bool
    {
        return PasswordResetToken::where('email', $email)->delete();
    }

    public function delete(string $userUid): bool
    {
        $user = $this->model::find($userUid);

        if (!$user) {
            throw new AuthException('User não encontrado', 404);
        }

        $user->tokens()->delete();

        $user->carteira()->delete();
        $user->operacoes()->delete();
        $user->proventos()->delete();
        $user->rebalanceamentoClasses()->delete();
        $user->rebalanceamentoAtivos()->delete();


        return $user->delete();
    }
}
