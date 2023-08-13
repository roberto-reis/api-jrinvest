<?php

namespace App\Actions\Portfolio;

use App\Interfaces\Repositories\ICarteiraRepository;
use App\Models\Cotacao;
use Illuminate\Support\Collection;

class ListAllAction
{
    public function __construct(private ICarteiraRepository $carteiraRepository)
    {}

    public function execute(array $filters = []): Collection
    {
        $portfolio = collect();
        // TODO: Falta impletação dos filtros

        $carteira = $this->carteiraRepository->getAll();
        $cotacoes = Cotacao::get(); // TODO: Criar e chamar o repository de cotação

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
