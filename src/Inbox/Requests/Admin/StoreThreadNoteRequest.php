<?php

namespace Modules\Inbox\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\Inbox\Rules\MessageBody;

class StoreThreadNoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                new MessageBody()
            ]
        ];
    }
}
