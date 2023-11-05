<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordResetToken extends Model
{
    use UuidTrait;
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    protected $icrementing = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
