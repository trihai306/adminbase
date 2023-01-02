<?php

namespace Modules\Inventory\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexInventoryItemRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules()
    {
        return $this->withPaginationRule([]);
    }
}
