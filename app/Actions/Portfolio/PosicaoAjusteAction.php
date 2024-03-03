<?php

namespace App\Actions\Portfolio;

use Illuminate\Support\Arr;
use App\Actions\Portfolio\PosicaoAtualAction;
use App\Actions\Portfolio\PosicaoIdealAction;
use App\Interfaces\Repositories\ICotacaoRepository;
use App\Interfaces\Repositories\ICarteiraRepository;

class PosicaoAjusteAction
{
    public function __construct(
        private ICarteiraRepository $carteiraRepository,
        private PosicaoAtualAction $posicaoAtual,
        private PosicaoIdealAction $posicaoIdeal,
        private ICotacaoRepository $cotacaoRepository
    )
    {}

    public function execute(): array
    {
        $portifolioAjuste = [];

        $portifolioAtual = $this->posicaoAtual->execute();
        $portifolioIdeal = $this->posicaoIdeal->execute();

        $valorTotalCarteira = $portifolioAtual['valor_total_carteira'];

        // Calcula ajuste de posição com base na posição ideal
        foreach ($portifolioIdeal['ativos'] as $ativo) {
            $ativoMinhaCarteira = $portifolioAtual['ativos']->firstWhere('ativo_uid', $ativo['ativo_uid']); // Pega o ativo da minha carteira

            if (!is_null($ativoMinhaCarteira)) {
                $ativo['quantidade'] = $ativo['quantidade'] - $ativoMinhaCarteira->quantidade_saldo; // Calcula a quantidade de ativos a ser ajustada
                $ativo['percentual'] = $ativo['percentual'] - $ativoMinhaCarteira->percentual; // Calcula o percentual de ajuste
                $ativo['valor_ativo'] = $ativo['valor_ativo'] - $ativoMinhaCarteira->valor_ativo; // Calcula o valor de ajuste
            }

            $ativo['acao'] = $ativo['valor_ativo'] > 0 ? 'Compra' : 'Vender';

            $portifolioAjuste[] = $ativo;
        }

        // Calcula ajuste com base na posição atual
        foreach ($portifolioAtual['ativos'] as $ativo) {
            $ativoPosicaoIdeal = Arr::where($portifolioIdeal['ativos'], fn($ativoIdeal) => $ativoIdeal['ativo_uid'] == $ativo['ativo_uid']);

            if (empty($ativoPosicaoIdeal)) {
                $portifolioAjuste[] = [
                    "codigo_ativo" => $ativo->codigo_ativo,
                    "percentual" => $ativo->percentual_na_carteira,
                    "valor_ativo" => $ativo->patrimonio,
                    "quantidade" => $ativo->quantidade,
                    "cotacao_atual" => $ativo->cotacao_atual,
                    'acao' => 'Vender'
                ];
            }
        }

        return [
            "ativos" => $portifolioAjuste,
            "valor_total_carteira" => $valorTotalCarteira,
        ];
    }
}
