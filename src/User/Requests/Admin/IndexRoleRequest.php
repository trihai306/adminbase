<?php

namespace Modules\User\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexRoleRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules(): array
    {
        return $this->withPaginationRule([]);
    }
}
