<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ativo extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'ativos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'codigo',
        'classe_ativo_uid',
        'nome',
        'setor'
    ];

    public function classeAtivo()
    {
        return $this->belongsTo(ClasseAtivo::class, 'classe_ativo_uid');
    }
}
