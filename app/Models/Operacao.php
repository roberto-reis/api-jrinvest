<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operacao extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'operacoes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_uid',
        'ativo_uid',
        'tipo_operacao_uid',
        'cotacao_preco',
        'quantidade',
        'corretora',
        'data_operacao',
    ];

    protected $appends = [
        'valor_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'ativo_uid', 'uid');
    }

    public function tipoOperacao()
    {
        return $this->belongsTo(TipoOperacao::class, 'tipo_operacao_uid', 'uid');
    }

    public function getValorTotalAttribute()
    {
        return $this->cotacao_preco * $this->attributes['quantidade'];
    }

}
