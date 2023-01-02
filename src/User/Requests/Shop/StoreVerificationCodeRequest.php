<?php

namespace Modules\User\Requests\Shop;

use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\User\Entities\User;
use Modules\User\Services\AuthenticationService;

class StoreVerificationCodeRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'action' => [
                'required',
                new In(['register'])
            ],
            'email' => [
                'required',
                'email'
            ],
            'domain' => [
                'filled',
                 'url'
            ]
        ];

        if ($this->input('action') === 'register') {
            $rules['email'][] = new Unique(User::class);
        }

        return $rules;
    }
}
