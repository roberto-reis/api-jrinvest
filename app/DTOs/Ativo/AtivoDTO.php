<?php

namespace App\DTOs\Ativo;

use App\DTOs\DataTransferObject;

class AtivoDTO extends DataTransferObject
{
    public ?string $codigo;
    public ?string $classe_ativo_uid = null;
    public ?string $nome;
    public ?string $setor;
}
