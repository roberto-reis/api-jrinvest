<?php

namespace App\Services\Api;

use App\Interfaces\ICotacaoBrapi;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CotacaoBrapiService implements ICotacaoBrapi
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = env('URL_COTACAO_BRAPI');
        $this->token = env('TOKEN_COTACAO_BRAPI');
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
            $response = Http::get($this->baseUrl . 'quote/'. $codigoAtivos . "?token={$this->token}");

            return $this->trataRespostaHttp($response);
        } catch (\Exception $e) {
            send_log('Erro ao consultar cotação de ações ou FII: ', [$e->getMessage()], 'error');
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
            $response = Http::get($this->baseUrl . "v2/crypto?token={$this->token}&coin=" . $codigoAtivos . '&currency=' . $moedaRef);

            return $this->trataRespostaHttp($response);
        } catch (\Exception $e) {
            send_log('Erro ao consultar cotação de criptomoedas: ', [$e->getMessage()], 'error');
        }

    }

    private function trataRespostaHttp(Response $response): array
    {
        if (!$response->ok() && !$response->created()) {
            send_log(
                'Requisição retornou diferente de 200 ou 201:',
                [
                    'status' => $response->status(),
                    ...$response->json()
                ]
            );

            return [];
        }

        return $response->json();
    }
}
