<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobileCardSerial implements Rule
{
    public function passes($attribute, $value)
    {
        return true;
    }

    public function message()
    {
        return trans('validation.mobile_card_serial');
    }
}
