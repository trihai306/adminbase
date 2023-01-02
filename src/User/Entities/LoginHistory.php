<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token_id',
        'ip',
        'agent',
        'country'
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\LoginHistoryFactory::new();
    }
}
