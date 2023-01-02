<?php

namespace Modules\Inbox\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Inbox\Entities\Thread;
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
