<?php

namespace Modules\Notification\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;

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

    public function build()
    {
        return $this->view('notification::verification-code-mail', [
            'action' => $this->action,
            'email' => $this->email,
            'code' => $this->code,
            'domain' => $this->domain
        ]);
    }
}
