<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\User\Services\OTPGenerator;
use ParagonIE\ConstantTime\Base32;

class VerificationRule implements Rule
{
    private $OTPGenerator;
    private $action;
    private $options;

    public function __construct($action, $options = [])
    {
        $this->OTPGenerator = new OTPGenerator();
        $this->action = $action;
        $this->options = $options;
    }

    public function passes($attribute, $value)
    {
        $code = request("${attribute}_verification_code");

        if (empty($code)) return false;

        $identifier = Base32::encodeUpper("$value|$this->action");
        return $this->OTPGenerator->verify($identifier, $code, $this->options);
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
