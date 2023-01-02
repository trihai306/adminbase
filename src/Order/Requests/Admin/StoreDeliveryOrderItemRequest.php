<?php

namespace Modules\Order\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class StoreDeliveryOrderItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => [
                'required',
                'array'
            ]
        ];
    }
}
