<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provento extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'proventos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_uid',
        'ativo_uid',
        'tipo_provento_uid',
        'corretora_uid',
        'data_com',
        'data_pagamento',
        'quantidade_ativo',
        'valor',
        'yield_on_cost'
    ];

}
