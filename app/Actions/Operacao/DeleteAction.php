<?php

namespace App\Actions\Operacao;

use Illuminate\Support\Facades\Auth;
use App\Events\ConsolidaCarteiraEvent;
use App\Interfaces\Repositories\IOperacaoRepository;


class DeleteAction
{
    public function __construct(private IOperacaoRepository $operacaoRepository)
    {}

    public function execute(string $uid): bool
    {
        $foiDeletado = $this->operacaoRepository->delete($uid);

        event(new ConsolidaCarteiraEvent(Auth::user()->uid));

        return $foiDeletado;
    }
}
