<?php

namespace App\Actions\Provento;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\ProventoException;
use App\Interfaces\Repositories\IAuthRepository;
use App\Interfaces\Repositories\IProventoRepository;

class ListAllAction
{
    public function __construct(
        private IProventoRepository $proventoRepository,
        private IAuthRepository $authRepository
    )
    {}

    public function execute(string $userUid, array $filters = []): array
    {
        if (!$this->authRepository->exists($userUid)) {
            throw new ProventoException("Usuário não encontrado", 404);
        }

        if ($userUid !== Auth::user()->uid) {
            throw new ProventoException("Usuário não autorizado", 403);
        }

        return $this->proventoRepository->getAll($userUid, $filters);
    }
}
