<?php

namespace Modules\Payment\Services;

use GuzzleHttp\Client;

class DTSRService
{
    public function send($data): array
    {
        if (config('payments.dtsr.debug')) {
            return [
                'success' => true,
                'message' => ''
            ];
        }

        $client = new Client();

        $response = $client->post('https://doithesieure.vn/api/card', [
            'json' => array_merge($data, [
                'ApiKey' => config('payments.dtsr.api_key'),
            ])
        ]);

        $body = json_decode((string) $response->getBody(), true);

        $code = $body['Code'] ?? $body['status'];
        $message = $body['Message'] ?? $body['message'];

        return [
            'success' => $code == 1,
            'message' => $message
        ];
    }
}
