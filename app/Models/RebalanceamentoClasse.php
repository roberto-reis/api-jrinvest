<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RebalanceamentoClasse extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'rebalanceamento_classes';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_id',
        'classe_ativo_uid',
        'percentual',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function classeAtivo()
    {
        return $this->hasOne(ClasseAtivo::class,  'uid', 'classe_ativo_uid');
    }
}
