<?php

namespace Modules\Catalog\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexVoucherRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules(): array
    {
        return $this->withPaginationRule([]);
    }
}