<?php

namespace App\Actions\Operacao;

use App\Interfaces\Repositories\IOperacaoRepository;

class ShowAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(string $uid): array
    {
        return $this->operacaoRepository->find($uid);
    }
}
