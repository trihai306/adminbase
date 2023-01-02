<?php

namespace Modules\Setting\Requests\Shop;

use Modules\Core\Requests\FormRequest;

class ShowSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keys' => 'array'
        ];
    }
}
