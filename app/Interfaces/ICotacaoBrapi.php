<?php

namespace App\Interfaces;

interface ICotacaoBrapi
{
    public function getCotacoes(string $codigoAtivos): array;
    public function getCotacoesCripto(string $codigoAtivos, string $moedaRef = 'BRL'): array;
}
