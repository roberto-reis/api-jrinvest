<?php

namespace App\DTOs\Carteira;

use App\DTOs\DataTransferObject;

class CarteiraUpdateOrCreateDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $ativo_uid;
    public ?string $quantidade;
    public ?string $preco_medio;
    public ?string $custo_total;
}

