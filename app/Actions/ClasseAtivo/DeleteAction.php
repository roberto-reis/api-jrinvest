<?php

namespace App\Actions\ClasseAtivo;

use App\Exceptions\ClasseAtivoNaoEncontradoException;
use App\Interfaces\Repositories\IClasseAtivoRepository;

class DeleteAction
{
    public function __construct(
        private IClasseAtivoRepository $classeAtivoRepository,
    )
    {}

    public function execute(string $uid): bool
    {
        return $this->classeAtivoRepository->delete($uid);
    }
}
