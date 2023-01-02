<?php

namespace Modules\Payment\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class DenyCardExchangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feedback' => 'nullable'
        ];
    }
}
