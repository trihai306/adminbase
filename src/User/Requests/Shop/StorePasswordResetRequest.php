<?php

namespace Modules\User\Requests\Shop;

use Modules\Core\Requests\FormRequest;

class StorePasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ]
        ];
    }
}
