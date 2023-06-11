<?php

namespace Tests\Feature;

use App\Interfaces\ICotacaoBrapi;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class CotacaoBrapiServiceTest extends TestCase
{
    private ICotacaoBrapi $cotacaoBrapiService;

    public function setUp(): void
    {
        parent::setUp();
        $this->cotacaoBrapiService = app(ICotacaoBrapi::class);
    }

    public function test_deve_retornar_cotacao_de_acoes_e_fii(): void
    {
        // Arrange
        $ativos = ['HCTR11', 'BBAS3'];

        // Action
        $response = $this->cotacaoBrapiService->getCotacoes(implode(',', $ativos));

        // Assert
        assertEquals($ativos[0], data_get($response, 'results.0.symbol'));
        assertEquals($ativos[1], data_get($response, 'results.1.symbol'));
    }

    public function test_deve_retornar_cotacao_de_criptomoedas(): void
    {
        // Arrange
        $ativos = ['BTC', 'ETH'];

        // Action
        $response = $this->cotacaoBrapiService->getCotacoesCripto(implode(',', $ativos));

        // Assert
        assertEquals($ativos[0], data_get($response, 'coins.0.coin'));
        assertEquals($ativos[1], data_get($response, 'coins.1.coin'));
    }
}
