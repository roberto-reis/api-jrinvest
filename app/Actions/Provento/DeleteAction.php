<?php

namespace App\Actions\Provento;

use App\Interfaces\Repositories\IProventoRepository;

class DeleteAction
{
    public function __construct(
        private IProventoRepository $proventoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        return $this->proventoRepository->delete($uid);
    }
}
