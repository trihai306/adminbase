<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Broadcast::routes([
            'prefix' => 'api/shop',
            'middleware' => 'auth:sanctum'
        ]);

        Broadcast::routes([
            'prefix' => 'api/admin',
            'middleware' => 'auth:sanctum'
        ]);

        require module_path('Notification', '/Routes/channels.php');
    }
}
