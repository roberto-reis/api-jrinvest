<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotacao extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'cotacoes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'ativo_uid',
        'moeda_ref',
        'preco',
    ];
}
