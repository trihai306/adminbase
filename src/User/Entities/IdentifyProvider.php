<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdentifyProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];
}
