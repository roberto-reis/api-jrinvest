<?php

namespace App\Actions\Provento;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\ProventoException;
use App\Interfaces\Repositories\IAuthRepository;
use App\Interfaces\Repositories\IProventoRepository;

class ShowAction
{
    public function __construct(
        private IProventoRepository $proventoRepository,
        private IAuthRepository $authRepository
    )
    {}

    public function execute(string $uid, string $userUid): array
    {
        if (!$this->authRepository->exists($userUid)) {
            throw new ProventoException("Usuário não encontrado", 404);
        }

        if ($userUid !== auth()->user()->uid) {
            throw new ProventoException("Usuário não autorizado", 403);
        }

        return $this->proventoRepository->find($uid, $userUid);
    }
}
