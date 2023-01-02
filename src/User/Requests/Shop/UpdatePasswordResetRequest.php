<?php

namespace Modules\User\Requests\Shop;

use Modules\Core\Requests\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                Password::default()
            ]
        ];
    }
}
