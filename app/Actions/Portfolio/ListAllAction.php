<?php

namespace App\Actions\Portfolio;

use App\Interfaces\Repositories\ICarteiraRepository;
use App\Models\Cotacao;

class ListAllAction
{
    public function __construct(private ICarteiraRepository $carteiraRepository)
    {}

    public function execute(array $filters = []): array
    {
        // TODO: Falta impletação dos filtros

        $carteira = $this->carteiraRepository->getAll();
        $cotacoes = Cotacao::get(); // TODO: Criar e chamar o repository de cotação

        // Calcula patrimonio
        $carteiraPatrimonio = $carteira->map(function ($ativo) use ($cotacoes) {
            $cotacao = $cotacoes->firstWhere('ativo_uid', $ativo->ativo_uid);
            $ativo->patrimonio = $ativo->quantidade * $cotacao->preco;
            $ativo->preco_atual = $cotacao->preco;
            return $ativo;
        });

        $patrimonioTotal = $carteiraPatrimonio->sum('patrimonio');
        $patrimonioPorClasse = $carteiraPatrimonio->groupBy('classe_ativo')->map(function ($ativos, $index) {
            return [
                'classe_ativo' => $index,
                'valor_total' => $ativos->sum('patrimonio')
            ];
        });

        // Calcular percentual
        $carteiraPatrimonio = $carteira->map(function ($ativo) use ($patrimonioTotal, $patrimonioPorClasse) {
            $valorTolalClasse = $patrimonioPorClasse->firstWhere('classe_ativo', $ativo->classe_ativo);

            $ativo->percentual_na_carteira = ($ativo->patrimonio / $patrimonioTotal) * 100;
            $ativo->percentual_classe = ($ativo->patrimonio / $valorTolalClasse['valor_total']) * 100;

            return $ativo;
        });

        return $carteiraPatrimonio->toArray();
    }
}
