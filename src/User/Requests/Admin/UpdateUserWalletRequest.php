<?php

namespace Modules\User\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class UpdateUserWalletRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'balance' => [
                'filled',
                'integer',
                'min:0'
            ]
        ];
    }
}
