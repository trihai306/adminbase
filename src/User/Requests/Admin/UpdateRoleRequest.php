<?php

namespace Modules\User\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'filled',
                (new Unique(Role::class))
                    ->ignore($this->route('role'))
            ],
            'display_name' => 'filled',
            'permission_ids' => [
                'array'
            ],
            'permission_ids.*' => [
                new Exists(Permission::class, 'id')
            ]
        ];
    }
}
