<?php

namespace Modules\User\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                new Unique(Role::class)
            ],
            'display_name' => 'required',
            'permission_ids' => [
                'required',
                'array'
            ],
            'permission_ids.*' => [
                new Exists(Permission::class, 'id')
            ]
        ];
    }
}
