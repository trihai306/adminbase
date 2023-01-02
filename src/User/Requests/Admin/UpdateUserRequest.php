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

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => [
                'filled',
                new MediaFile(MediaType::IMAGE)
            ],
            'full_name' => 'filled',
            'email' => [
                'filled',
                'email',
                (new Unique(User::class))->ignore($this->route('user'))
            ],
            'phone' => [
                'filled',
                new PhoneNumber(),
                (new Unique(User::class))->ignore($this->route('user'))
            ],
            'birthday' => [
                'filled',
                'date'
            ],
            'gender' => [
                'filled',
                new EnumValue(UserGender::class)
            ],
            'password' => [
                'filled',
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
