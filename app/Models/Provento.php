<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ativo;
use App\Models\Corretora;
use App\Traits\UuidTrait;
use App\Models\TipoProvento;
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid');
    }

    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'ativo_uid');
    }

    public function tipoProvento()
    {
        return $this->belongsTo(TipoProvento::class, 'tipo_provento_uid');
    }

    public function corretora()
    {
        return $this->belongsTo(Corretora::class, 'corretora_uid');
    }
}
