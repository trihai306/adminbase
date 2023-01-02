<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IdentifyProviderConnection extends Pivot
{
    protected $fillable = [
        'user_id',
        'identify_provider_id',
        'identify_provider_user_id'
    ];
}
