<?php

namespace App\DTOs\Provento;

use App\DTOs\DataTransferObject;

class StoreProventoDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $ativo_uid;
    public ?string $tipo_provento_uid;
    public ?string $corretora_uid;
    public ?string $data_com;
    public ?string $data_pagamento;
    public ?float $quantidade_ativo;
    public ?float $valor;
    public ?float $valor_total;
    public ?float $yield_on_cost;
}

