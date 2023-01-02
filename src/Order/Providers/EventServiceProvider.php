<?php

namespace Modules\Order\Providers;

use Modules\Order\Events\NewOrder;
use Modules\Order\Events\OrderPaid;
use Modules\Order\Listeners\DeliverPaidOrder;
use \Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewOrder::class => [
            DeliverPaidOrder::class
        ],
        OrderPaid::class => [
            DeliverPaidOrder::class
        ]
    ];
}
