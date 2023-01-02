<?php

namespace Modules\Catalog\Requests\Admin;


use Modules\Core\Requests\FormRequest;
class ByVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
