<?php

namespace Modules\Payment\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethodType extends Enum
{
    const BALANCE = 'balance';
    const BANK_TRANSFER = 'bank_transfer';
    const EWALLET_TRANSFER = 'ewallet_transfer';
    const CARD = 'card';
    const CRYPTOCURRENCY_TRANSFER = 'cryptocurrency_transfer';
    const GATEWAY = 'gateway';
    const OFFLINE = 'offline';
}
