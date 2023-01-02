<?php

return [
    'bank_transfer' => [
        'api_key' => env('PAYMENT_BANK_TRANSFER_API_KEY', 'api_key')
    ],
    'dtsr' => [
        'debug' => env('PAYMENT_DTSR_DEBUG', false),
        'api_key' => env('PAYMENT_DTSR_API_KEY', 'api_key'),
    ]
];
