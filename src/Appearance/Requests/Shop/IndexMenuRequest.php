<?php

namespace Modules\Appearance\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Requests\Traits\HasPaginationRule;

class IndexMenuRequest extends FormRequest
{
    use HasPaginationRule;

    public function rules(): array
    {
        return $this->withPaginationRule([]);
    }
}
