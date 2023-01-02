<?php

namespace Modules\Order\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class CancelOrderItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feedback' => 'nullable'
        ];
    }
}
