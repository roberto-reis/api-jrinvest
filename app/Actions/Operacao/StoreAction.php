<?php

namespace App\Actions\Operacao;

use App\DTOs\Operacao\OperacaoDTO;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\IOperacaoRepository;

class StoreAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(array $operacao = []): array
    {
        $operacaoDTO = new OperacaoDTO($operacao);
        $operacaoDTO->user_uid = Auth::user()->uid;

        return $this->operacaoRepository->store($operacaoDTO);
    }
}
