<?php

namespace App\Actions\Provento;

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

    public function execute(string $uid): array
    {
        return $this->proventoRepository->find($uid);
    }
}
