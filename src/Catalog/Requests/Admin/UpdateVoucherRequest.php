<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\VoucherOptions;
use Modules\Catalog\Enums\VoucherType;
use Modules\Core\Requests\FormRequest;
use Modules\User\Entities\User;

class UpdateVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
            ],
            'name' => 'nullable',
            'title' => 'nullable',
            'max_money' => 'nullable',
            'discount' => 'nullable',
            'total_user' => 'nullable',
            'quality' => 'nullable',
            'point' => 'nullable',
            'description' => 'nullable',
            'expire_day' => 'required',
            'dateRange' => 'nullable',
            'status'=>'nullable',
            'type' => [
                new EnumValue(VoucherType::class)
            ],
            'options' => [
                new EnumValue(VoucherOptions::class)
            ],
            'variant_ids' => [
                'array',
                new Exists(Variant::class, 'id')
            ],
            'product_ids' => [
                'array',
                new Exists(Product::class, 'id')
            ],
            'user_ids' => [
                'array',
                new Exists(User::class, 'id')
            ],
        ];
    }
}
