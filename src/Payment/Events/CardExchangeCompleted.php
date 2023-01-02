<?php

namespace Modules\Payment\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CardExchangeCompleted extends CardExchangeEvent implements ShouldBroadcast
{
    public function broadcastAs()
    {
        return 'card-exchange-completed';
    }
}
