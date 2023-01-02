<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification;
use Modules\Notification\Services\NotificationService;

class Notification extends DatabaseNotification
{
    public function getMessageAttribute()
    {
        return app(NotificationService::class)->makeMessage($this);
    }

    public function scopeMarkAsRead(Builder $builder): int
    {
        return $builder->update(['read_at' => now()]);
    }
}
