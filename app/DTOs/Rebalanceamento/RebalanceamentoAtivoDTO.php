<?php

namespace App\DTOs\Rebalanceamento;

use App\DTOs\DataTransferObject;

class RebalanceamentoAtivoDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $ativo_uid;
    public ?float $percentual;
}
