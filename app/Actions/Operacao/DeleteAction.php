<?php

namespace App\Actions\Operacao;

use App\Interfaces\Repositories\IOperacaoRepository;


class DeleteAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(string $uid): bool
    {
        return $this->operacaoRepository->delete($uid);
    }
}
