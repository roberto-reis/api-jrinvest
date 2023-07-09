<?php

namespace App\Actions\Operacao;

use App\Interfaces\Repositories\IOperacaoRepository;

class ListAllAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(array $filters = []): array
    {
        return $this->operacaoRepository->getAll($filters);
    }
}
