<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Core\Utils\StringUtil;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        return StringUtil::isPhone($value);
    }

    public function message()
    {
        return trans('validation.phone_number');
    }
}
