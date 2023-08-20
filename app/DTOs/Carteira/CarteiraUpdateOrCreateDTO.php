<?php

namespace App\DTOs\Carteira;

use App\DTOs\DataTransferObject;

class CarteiraUpdateOrCreateDTO extends DataTransferObject
{
    public ?string $user_uid;
    public ?string $ativo_uid;
    public ?float $quantidade;
    public ?float $preco_medio;
    public ?float $custo_total;

    public function register(
        string $user_uid,
        string $ativo_uid,
        float $quantidade,
        float $preco_medio,
        float $custo_total
    ): self
    {
        $this->user_uid = $user_uid;
        $this->ativo_uid = $ativo_uid;
        $this->quantidade = $quantidade;
        $this->preco_medio = $preco_medio;
        $this->custo_total = $custo_total;

        return $this;
    }
}

