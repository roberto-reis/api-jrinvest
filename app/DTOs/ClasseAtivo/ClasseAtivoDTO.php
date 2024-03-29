<?php

namespace App\DTOs\ClasseAtivo;

use App\DTOs\DataTransferObject;

class ClasseAtivoDTO extends DataTransferObject
{
    public ?string $nome;
    public ?string $descricao;
    public ?string $nome_interno;
}
