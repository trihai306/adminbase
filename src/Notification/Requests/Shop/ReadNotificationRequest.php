<?php

namespace Modules\Notification\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Notification\Entities\Notification;

class ReadNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => 'array',
            'ids.*' => new Exists(Notification::class, 'id')
        ];
    }
}
