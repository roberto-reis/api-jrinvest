<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ativo;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RebalanceamentoAtivo extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'rebalanceamento_ativos';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_uid',
        'ativo_uid',
        'percentual',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'uid', 'user_uid');
    }

    public function ativo()
    {
        return $this->hasOne(Ativo::class,  'uid', 'ativo_uid');
    }
}
