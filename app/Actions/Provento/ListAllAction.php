<?php

namespace App\Actions\Provento;

use App\Interfaces\Repositories\IAuthRepository;
use App\Interfaces\Repositories\IProventoRepository;

class ListAllAction
{
    public function __construct(private IProventoRepository $proventoRepository)
    {}

    public function execute(array $filters = []): array
    {
        return $this->proventoRepository->getAll($filters);
    }
}
