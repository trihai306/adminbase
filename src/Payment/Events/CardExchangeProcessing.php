<?php

namespace Modules\Payment\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CardExchangeProcessing extends CardExchangeEvent implements ShouldBroadcast
{
    public function broadcastAs()
    {
        return 'card-exchange-processing';
    }
}
