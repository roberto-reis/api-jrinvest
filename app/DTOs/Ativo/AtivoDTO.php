<?php

namespace App\DTOs\Ativo;

use App\DTOs\DataTransferObject;

class AtivoDTO extends DataTransferObject
{
    public ?string $codigo;
    public ?string $classe_ativo_uid = null;
    public ?string $nome;
    public ?string $setor;

    public function setCodigoStrtoupper()
    {
        $this->codigo = strtoupper($this->codigo);
        return $this;
    }
}

