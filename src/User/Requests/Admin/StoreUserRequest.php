<?php

namespace Modules\User\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Core\Rules\PhoneNumber;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Enums\UserGender;
use Modules\User\Enums\UserStatus;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => [
                'nullable',
                new MediaFile(MediaType::IMAGE)
            ],
            'full_name' => 'nullable',
            'email' => [
                'required',
                'email',
                new Unique(User::class)
            ],
            'phone' => [
                'nullable',
                new PhoneNumber(),
                new Unique(User::class)
            ],
            'birthday' => [
                'nullable',
                'date'
            ],
            'gender' => [
                'nullable',
                new EnumValue(UserGender::class)
            ],
            'is_admin' => [
                'nullable',
                'boolean'
            ],
            'password' => [
                'required',
                Password::default()
            ],
            'role_ids' => [
                'array',
                new Exists(Role::class, 'id')
            ],
            'status' => [
                'filled',
                new EnumValue(UserStatus::class)
            ]
        ];
    }
}
