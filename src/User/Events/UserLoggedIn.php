<?php

namespace Modules\User\Events;

use Illuminate\Queue\SerializesModels;

class UserLoggedIn
{
    use SerializesModels;

    public $user;
    public $ip;
    public $agent;
    public $token;

    public function __construct($user, $ip, $agent, $token)
    {
        $this->user = $user;
        $this->ip = $ip;
        $this->agent = $agent;
        $this->token = $token;
    }
}
