<?php

namespace Modules\Inbox\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;

class MessageBody implements Rule
{
    public function passes($attribute, $value)
    {
        if (is_string($value)) {
            return true;
        }

        $validator =  Validator::make($value, [
            'image' => new MediaFile(MediaType::IMAGE)
        ]);

        return !$validator->fails();
    }

    public function message()
    {
        return trans('validation.message_body');
    }
}
