<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoOperacao extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'tipos_operacoes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'nome',
        'nome_interno'
    ];
}
