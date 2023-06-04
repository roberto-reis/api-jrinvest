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

    public function execute(array $filters = []): array
    {
        return $this->proventoRepository->getAll($filters);
    }
}
