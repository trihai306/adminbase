<?php

namespace Modules\User\Requests\Admin;

use Modules\Core\Requests\FormRequest;

class StoreTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account' => 'required',
            'password' => 'required'
        ];
    }
}
