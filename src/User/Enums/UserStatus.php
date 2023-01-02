<?php

namespace Modules\User\Enums;

use BenSampo\Enum\Enum;

class UserStatus extends Enum
{
    const ACTIVATED = 'activated';
    const BLOCKED = 'blocked';
}
