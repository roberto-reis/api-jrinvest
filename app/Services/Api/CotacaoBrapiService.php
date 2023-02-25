<?php

namespace App\Services\Api;

use App\Interfaces\ICotacaoBrapi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CotacaoBrapiService implements ICotacaoBrapi
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('URL_COTACAO_BRAPI');
    }

    /**
     * Pegar Cotação de ações e FII
     * ex ativo separado por virgula: 'BTLG11,B3SA3'
     * @param string $codigoAtivos
     * @return array
     */
    public function getCotacoes(string $codigoAtivos): array
    {
        try {
            $response = Http::get($this->baseUrl . 'quote/'. $codigoAtivos);


            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Erro ao consultar cotação de ações ou FII: ', [$e->getMessage()]);
        }

    }

    /**
     * Pegar cotacao para criptomoedas
     * ex codigo do ativo separado por virgula: 'BTC,ETH,ADA'
     * @param string $ativo
     * @param string $moedaRef
     * @return array
     */
    public function getCotacoesCripto(string $codigoAtivos, string $moedaRef = 'BRL'): array
    {
        try {
            $response = Http::get($this->baseUrl . 'v2/crypto?coin=' . $codigoAtivos . '&currency=' . $moedaRef);

            if ($response->successful()) {
                return $response->json();
            }
            return [];
        } catch (\Exception $e) {
            Log::error('Erro ao consultar cotação de criptomoedas: ', [$e->getMessage()]);
        }

    }

}
