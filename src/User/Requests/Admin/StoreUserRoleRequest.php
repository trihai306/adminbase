<?php

namespace Modules\User\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Spatie\Permission\Models\Role;

class StoreUserRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => [
                'required',
                new Exists(Role::class, 'id')
            ]
        ];
    }
}
