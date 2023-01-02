<?php

namespace Modules\Notification\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexNotificationRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules(): array
    {
        return $this->withPaginationRule([]);
    }
}
