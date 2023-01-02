<?php

use Modules\Order\Enums\OrderItemStatus;

return [
    OrderItemStatus::class => [
        OrderItemStatus::NEW => 'Mới',
        OrderItemStatus::PENDING => 'Chờ xử lý',
        OrderItemStatus::DELIVERING => 'Đang xử lý',
        OrderItemStatus::COMPLETED => 'Hoàn thành',
        OrderItemStatus::CANCELED => 'Bị hủy',
    ]
];
