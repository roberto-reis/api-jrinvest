<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClasseAtivo extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'classes_ativos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'nome',
        'nome_interno',
        'descricao',
    ];

    public function ativos()
    {
        return $this->hasMany(Ativo::class, 'classe_ativo_uid', 'uid');
    }
}
