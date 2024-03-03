<?php

namespace App\Actions\Portfolio;

use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;

class PosicaoAtualAction
{
    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private ICotacaoRepository $cotacaoRepository
    )
    {}

    public function execute(): array
    {
        $portfolio = collect();

        $carteira = $this->carteiraRepository->getAll();
        $cotacoes = $this->cotacaoRepository->getAll();

        if ($cotacoes->isEmpty()) throw new \Exception("Sem dados de cotações");

        // Calcula patrimonio por ativo
        $carteiraPatrimonio = $carteira->map(function ($ativo) use ($cotacoes) {
            $cotacao = $cotacoes->firstWhere('ativo_uid', $ativo->ativo_uid);
            $ativo->patrimonio = $ativo->quantidade * $cotacao->preco;
            $ativo->cotacao_atual = $cotacao->preco;

            return $ativo;
        });

        $patrimonioTotal = $carteiraPatrimonio->sum('patrimonio');

        foreach ($carteiraPatrimonio->groupBy('classe_ativo') as $ativosPorClasse) {
            $somaTotalPorClasse = $ativosPorClasse->sum('patrimonio');

            // Calcular percentual na carteira e por classe
            $carteiraPatrimonio = $ativosPorClasse->map(function ($ativo) use ($patrimonioTotal, $somaTotalPorClasse) {
                $ativo->percentual_na_carteira = ($ativo->patrimonio / $patrimonioTotal) * 100;
                $ativo->percentual_classe = ($ativo->patrimonio / $somaTotalPorClasse) * 100;

                return $ativo;
            });

            $portfolio->push(...$carteiraPatrimonio);
        }

        return [
            "ativos" => $portfolio,
            "valor_total_carteira" => $patrimonioTotal,
        ];
    }
}
