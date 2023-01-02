<?php

namespace Modules\Payment\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class UpdateBankRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'filled',
            'image' => 'nullable',
            'account_name' => 'filled',
            'account_number' => 'filled',
            'branch' => 'filled',
            'discount_rate' => [
                'filled',
                'integer',
                'min:0',
                'max:100'
            ],
            'enabled' => [
                'filled',
                'boolean'
            ],
        ];
    }
}
