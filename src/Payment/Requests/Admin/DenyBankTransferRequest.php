<?php

namespace Modules\Payment\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class DenyBankTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feedback' => 'nullable'
        ];
    }
}
