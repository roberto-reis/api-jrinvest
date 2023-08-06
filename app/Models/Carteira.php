<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ativo;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carteira extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'carteiras';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    protected $fillable = [
        'user_uid',
        'ativo_uid',
        'quantidade',
        'preco_medio',
        'custo_total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'ativo_uid', 'uid');
    }
}
