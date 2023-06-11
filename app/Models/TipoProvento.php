<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoProvento extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'tipos_proventos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'nome',
        'nome_interno'
    ];

}
