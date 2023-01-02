<?php

namespace Modules\User\Requests\Shop;

use Illuminate\Validation\Rules\In;
use Modules\Core\Requests\FormRequest;
use Modules\User\Services\AuthenticationService;

class StoreTokenRequest extends FormRequest
{
    public function rules(): array
    {
        $supportedSocials = app(AuthenticationService::class)
            ->getSupportedSocials();

        $rules = [
            'type' => new In(array_merge([
                'credentials'
            ], $supportedSocials))
        ];

        if (in_array($this->input('type'), $supportedSocials)) {
            $rules['token'] = 'required';
        } else {
            $rules['account'] = 'required';
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
