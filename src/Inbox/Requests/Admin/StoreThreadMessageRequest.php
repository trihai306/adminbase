<?php

namespace Modules\Inbox\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\Inbox\Rules\MessageBody;

class StoreThreadMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                new MessageBody()
            ]
        ];
    }
}
