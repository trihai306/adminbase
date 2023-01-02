<?php

namespace Modules\Core\Utils;

class StringUtil
{
    const PHONE_PATTERN = '/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])\d{7}$/';

    public static function isEmail($str)
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    public static function isPhone($str)
    {
        return preg_match(self::PHONE_PATTERN, $str);
    }
}
