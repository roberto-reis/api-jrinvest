<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UuidTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UuidTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    protected $icrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'avatar',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Casteiras
    public function carteira(): HasMany
    {
        return $this->hasMany(Carteira::class, 'user_uid', 'uid');
    }

    public function operacoes(): HasMany
    {
        return $this->hasMany(Operacao::class, 'user_uid', 'uid');
    }

    public function proventos(): HasMany
    {
        return $this->hasMany(Provento::class, 'user_uid', 'uid');
    }

    public function rebalanceamentoClasses(): HasMany
    {
        return $this->hasMany(RebalanceamentoClasse::class, 'user_uid', 'uid');
    }

    public function rebalanceamentoAtivos(): HasMany
    {
        return $this->hasMany(RebalanceamentoAtivo::class, 'user_uid', 'uid');
    }
}
