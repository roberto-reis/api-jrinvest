<?php

namespace App\Actions\Provento;

use App\Interfaces\Repositories\IProventoRepository;

class ShowAction
{
    public function __construct(private IProventoRepository $proventoRepository)
    {}

    public function execute(string $uid): array
    {
        return $this->proventoRepository->find($uid);
    }
}
