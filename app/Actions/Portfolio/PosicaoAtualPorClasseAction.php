<?php

namespace App\Actions\Portfolio;

use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;

class PosicaoAtualPorClasseAction
{
    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private ICotacaoRepository $cotacaoRepository
    ){}

    public function execute(): array
    {
        $portfolioPorClasse = collect();

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

        foreach ($carteiraPatrimonio->groupBy('classe_ativo') as $classe => $ativosPorClasse) {
            $somaTotalPorClasse = $ativosPorClasse->sum('patrimonio');

            $portfolioPorClasse->push([
                'classe' => $classe,
                'valor_total' => $somaTotalPorClasse,
                'percentual' => ($somaTotalPorClasse / $patrimonioTotal) * 100
            ]);
        }

        return [
            "classes" => $portfolioPorClasse,
            "valor_total_carteira" => $patrimonioTotal,
        ];
    }
}
