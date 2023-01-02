<?php

namespace Modules\User\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Core\Rules\PhoneNumber;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\User\Entities\User;
use Modules\User\Enums\UserGender;

class UpdateMeRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->user();

        return [
            'avatar' => [
                'filled',
                new MediaFile(MediaType::IMAGE)
            ],
            'full_name' => 'filled',
            'email' => [
                'filled',
                'email',
                (new Unique(User::class))->ignore($user->id)
            ],
            'phone' => [
                'filled',
                new PhoneNumber(),
                (new Unique(User::class))->ignore($user->id)
            ],
            'birthday' => [
                'filled',
                'date'
            ],
            'gender' => [
                'filled',
                new EnumValue(UserGender::class)
            ],
            'address' => 'nullable',
            'password' => [
                'filled',
                Password::default()
            ],
            'old_password' => [
                'required_with:password',
                'password'
            ]
        ];
    }
}
