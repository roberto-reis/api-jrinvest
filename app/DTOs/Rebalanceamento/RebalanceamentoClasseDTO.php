<?php

namespace App\DTOs\Rebalanceamento;

use App\DTOs\DataTransferObject;

class RebalanceamentoClasseDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $classe_ativo_uid;
    public ?float $percentual;
}
