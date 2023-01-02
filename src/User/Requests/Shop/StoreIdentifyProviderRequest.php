<?php

namespace Modules\User\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Product;
use Modules\Core\Requests\FormRequest;
use Modules\User\Entities\IdentifyProvider;

class StoreIdentifyProviderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'provider' => [
                'required',
                new Exists(IdentifyProvider::class, 'code')
            ],
            'token' => 'required'
        ];
    }
}
