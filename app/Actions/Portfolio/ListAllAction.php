<?php

namespace App\Actions\Portfolio;

use Illuminate\Support\Collection;
use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;

class ListAllAction
{
    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private ICotacaoRepository $cotacaoRepository
    )
    {}

    public function execute(array $filters = []): Collection
    {
        $portfolio = collect();
        // TODO: Falta impletação dos filtros

        $carteira = $this->carteiraRepository->getAll();
        $cotacoes = $this->cotacaoRepository->getAll(now());

        // Calcula patrimonio por ativo
        $carteiraPatrimonio = $carteira->map(function ($ativo) use ($cotacoes) {
            $cotacao = $cotacoes->firstWhere('ativo_uid', $ativo->ativo_uid);
            $ativo->patrimonio = $ativo->quantidade * $cotacao->preco;
            $ativo->preco_atual = $cotacao->preco;
            return $ativo;
        });

        $patrimonioTotal = $carteiraPatrimonio->sum('patrimonio');

        foreach ($carteiraPatrimonio->groupBy('classe_ativo') as $ativosPorClasse) {
            $somaTotalPorClasse = $ativosPorClasse->sum('patrimonio');

            // Calcular percentual
            $carteiraPatrimonio = $ativosPorClasse->map(function ($ativo) use ($patrimonioTotal, $somaTotalPorClasse) {
                $ativo->percentual_na_carteira = ($ativo->patrimonio / $patrimonioTotal) * 100;
                $ativo->percentual_classe = ($ativo->patrimonio / $somaTotalPorClasse) * 100;

                return $ativo;
            });

            $portfolio->push(...$carteiraPatrimonio);
        }

        return $portfolio;
    }
}
