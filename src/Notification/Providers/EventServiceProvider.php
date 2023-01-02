<?php

namespace Modules\Notification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Notification\Listeners\SendNewTransactionNotification;
use Modules\Notification\Listeners\SendNewOrderNotification;
use Modules\Notification\Listeners\SendNewVerificationCodeNotification;
use Modules\Order\Events\NewOrder;
use Modules\User\Events\NewTransaction;
use Modules\User\Events\NewVerificationCode;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewTransaction::class => [
            SendNewTransactionNotification::class
        ],
        NewOrder::class => [
            SendNewOrderNotification::class
        ],
        NewVerificationCode::class => [
            SendNewVerificationCodeNotification::class
        ]
    ];
}
