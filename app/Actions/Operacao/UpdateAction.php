<?php

namespace App\Actions\Operacao;

use App\DTOs\Operacao\OperacaoDTO;
use Illuminate\Support\Facades\Auth;
use App\Events\ConsolidaCarteiraEvent;
use App\Interfaces\Repositories\IOperacaoRepository;

class UpdateAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(string $uid, array $operacao = []): array
    {
        $operacaoDTO = new OperacaoDTO($operacao);
        $operacaoDTO->user_uid = Auth::user()->uid;

        $operacao = $this->operacaoRepository->update($uid, $operacaoDTO);

        event(new ConsolidaCarteiraEvent(Auth::user()->uid));

        return $operacao;
    }
}
