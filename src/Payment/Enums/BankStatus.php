<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

class BankStatus extends Enum
{
    const ACTIVATED = 'activated';
    const DEACTIVATED = 'deactivated';
}
