<?php

namespace Modules\User\Requests\Shop;

use BenSampo\Enum\Rules\EnumValue;
use Modules\Core\Requests\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Rules\PhoneNumber;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\User\Entities\User;
use Modules\User\Enums\UserGender;
use Modules\User\Rules\VerificationRule;

class StoreCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => [
                'filled',
                new MediaFile(MediaType::IMAGE)
            ],
            'username' => [
                'filled',
                new Unique(User::class)
            ],
            'full_name' => 'filled',
            'email' => [
                'required',
                'email',
                new Unique(User::class),
                new VerificationRule('register', [
                    'digits' => 6,
                    'period' => 600
                ])
            ],
            'phone' => [
                'filled',
                new PhoneNumber(),
                new Unique(User::class)
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
                'required',
                Password::default()
            ],
        ];
    }
}
