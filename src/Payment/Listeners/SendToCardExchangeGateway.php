<?php

namespace Modules\Payment\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Payment\Jobs\SendToDTSR;

class SendToCardExchangeGateway
{
    public function handle($event)
    {
        SendToDTSR::dispatch($event->cardExchange);
    }
}
