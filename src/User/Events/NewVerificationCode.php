<?php

namespace Modules\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\Transaction;

class NewVerificationCode
{
    use SerializesModels, Dispatchable;

    public $code;
    public $email;
    public $action;
    public $domain;

    public function __construct($code, $email, $action, $domain = null)
    {
        $this->code = $code;
        $this->email = $email;
        $this->action = $action;
        $this->domain = $domain;
    }
}
