<?php

namespace App\DTOs\Operacao;

use App\DTOs\DataTransferObject;

class OperacaoDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $ativo_uid;
    public ?string $tipo_operacao_uid;
    public ?string $corretora_uid;
    public ?float $cotacao_preco;
    public ?float $quantidade;
    public ?string $data_operacao;
}

