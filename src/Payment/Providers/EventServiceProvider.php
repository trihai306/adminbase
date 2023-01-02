<?php

namespace Modules\Payment\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Payment\Events\NewCardExchange;
use Modules\Payment\Listeners\SendToCardExchangeGateway;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewCardExchange::class => [
            SendToCardExchangeGateway::class
        ]
    ];
}
