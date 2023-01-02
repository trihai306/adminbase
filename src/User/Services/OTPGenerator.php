<?php

namespace Modules\User\Services;

use OTPHP\TOTP;

class OTPGenerator
{
    public function generate($identifier, $options = [])
    {
        $otp = $this->create($identifier, $options);

        return $otp->now();
    }

    public function verify($identifier, $code, $options = [])
    {
        $otp = $this->create($identifier, $options);

        return $otp->verify($code);
    }

    protected function create($identifier, $options = [])
    {
        $otp = TOTP::create($identifier);

        if (isset($options['digits'])) {
            $otp->setParameter('digits', $options['digits']);
        }

        if (isset($options['period'])) {
            $otp->setParameter('period', $options['period']);
        }

        return $otp;
    }
}
