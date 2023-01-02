<?php

namespace Modules\Payment\Requests\Admin;

use Modules\Core\Requests\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexBankTransferRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules(): array
    {
        return $this->withPaginationRule([]);
    }
}
