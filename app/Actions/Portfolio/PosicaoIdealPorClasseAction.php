<?php

namespace App\Actions\Portfolio;

use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;
use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class PosicaoIdealPorClasseAction
{
    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private ICotacaoRepository $cotacaoRepository,
        private IRebalanceamentoClasseRepository $rebalanceamentoClasseRepository,
    ){}

    public function execute(): array
    {
        $portfolioPorClasse = [];

        $portfolioAtualPorClasse = $this->carteiraRepository->getAll();
        $cotacoes = $this->cotacaoRepository->getAll();
        $rebalanceamentoClasse = $this->rebalanceamentoClasseRepository->getAll();

        if ($cotacoes->isEmpty()) throw new \Exception("Sem dados de cotações");

        // Calcula patrimonio por ativo
        $carteiraPatrimonio = $portfolioAtualPorClasse->map(function ($ativo) use ($cotacoes) {
            $cotacao = $cotacoes->firstWhere('ativo_uid', $ativo->ativo_uid);
            $ativo->patrimonio = $ativo->quantidade * $cotacao->preco;
            $ativo->cotacao_atual = $cotacao->preco;

            return $ativo;
        });

        $patrimonioTotal = $carteiraPatrimonio->sum('patrimonio');

        foreach ($rebalanceamentoClasse as $classe) {
            $portfolioPorClasse[] = [
                'classe' => $classe['classe_ativo'],
                'valor_total' => $patrimonioTotal * ($classe['percentual'] / 100),
                'percentual' => $classe['percentual']
            ];
        }

        return [
            "classes" => $portfolioPorClasse,
            "valor_total_carteira" => $patrimonioTotal,
        ];
    }
}
