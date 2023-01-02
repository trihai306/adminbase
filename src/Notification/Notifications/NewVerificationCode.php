<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notification\Emails\VerificationCode;

class NewVerificationCode extends Notification implements ShouldQueue
{
    use Queueable;

    private $action;
    private $email;
    private $code;
    private $domain;

    public function __construct($action, $email, $code, $domain)
    {
        $this->action = $action;
        $this->email = $email;
        $this->code = $code;
        $this->domain = $domain;
    }

    public function via($notifiable): array
    {
        return [
            'mail'
        ];
    }

    public function toMail($notifiable)
    {
        return new VerificationCode($this->action, $this->email, $this->code, $this->domain);
    }
}
