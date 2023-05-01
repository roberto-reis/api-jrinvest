<?php

namespace App\Actions\Ativo;

use App\Exceptions\AtivoNaoEncontradoException;
use App\Interfaces\Repositories\IAtivoRepository;

class DeleteAction
{
    public function __construct(
        private IAtivoRepository $ativoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        if (!$this->ativoRepository->exists($uid)) {
            throw new AtivoNaoEncontradoException();
        }

        return $this->ativoRepository->delete($uid);
    }
}
