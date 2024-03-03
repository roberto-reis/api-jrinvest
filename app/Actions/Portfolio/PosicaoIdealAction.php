<?php

namespace App\Actions\Portfolio;

use App\Actions\Portfolio\PosicaoAtualAction;
use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class PosicaoIdealAction
{
    public function __construct(
        private IRebalanceamentoAtivoRepository $rebalanceamentoAtivoRepository,
        private ICarteiraRepository $carteiraRepository,
        private PosicaoAtualAction $posicaoAtual,
        private ICotacaoRepository $cotacaoRepository
    )
    {}

    public function execute(): array
    {
        $portifolioIdeal = [];

        $portifolioAtual = $this->posicaoAtual->execute();
        $cotacoes = $this->cotacaoRepository->getAll();
        $rebalanceamentoAtivo = $this->rebalanceamentoAtivoRepository->getAll();

        if ($cotacoes->isEmpty()) throw new \Exception("Sem dados de cotações");

        $valorTotalCarteira = $portifolioAtual['valor_total_carteira'];

        foreach ($rebalanceamentoAtivo as $ativo) {
            $cotacao = $cotacoes->where('ativo_uid', $ativo['ativo_uid'])->first();

            $valor_ativo = ($valorTotalCarteira * $ativo['percentual']) / 100; // Calcula o valor do ativo com base no percentual ideal
            $quantidade_ativo = $valor_ativo / $cotacao->preco; // Calcula a quantidade do ativo com base na cotação atual

            $portifolioIdeal[] = [
                "ativo_uid" => $ativo['ativo_uid'],
				"codigo_ativo" => $ativo['codigo_ativo'],
                "percentual" => $ativo['percentual'],
				"valor_ativo" => $valor_ativo,
				"quantidade" => $quantidade_ativo,
				"cotacao_atual" => $cotacao->preco,
            ];
        }

        return [
            "ativos" => $portifolioIdeal,
            "valor_total_carteira" => $valorTotalCarteira,
        ];
    }
}
