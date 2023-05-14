<?php

namespace App\Actions\ClasseAtivo;

use App\Interfaces\Repositories\IClasseAtivoRepository;

class ShowAction
{
    public function __construct(
        private IClasseAtivoRepository $classeAtivoRepository
    )
    {}

    public function execute(string $uid): array
    {
        $classeAtivo = $this->classeAtivoRepository->find($uid);
        return $classeAtivo;
    }
}
