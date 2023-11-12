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
        $ativo = 'HCTR11';

        // Action
        $response = $this->cotacaoBrapiService->getCotacoes($ativo);

        // Assert
        assertEquals($ativo, data_get($response, 'results.0.symbol'));
    }

    public function test_deve_retornar_cotacao_de_criptomoedas(): void
    {
        // Arrange
        $ativo = 'BTC';

        // Action
        $response = $this->cotacaoBrapiService->getCotacoesCripto($ativo);

        // Assert
        assertEquals($ativo, data_get($response, 'coins.0.coin'));
    }
}
