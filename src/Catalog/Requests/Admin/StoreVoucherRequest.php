<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Entities\Voucher;
use Modules\Catalog\Enums\VoucherOptions;
use Modules\Catalog\Enums\VoucherType;
use Modules\Core\Requests\FormRequest;
use Modules\User\Entities\User;

class StoreVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                new Unique(Voucher::class)
            ],
            'name' => 'required',
            'title' => 'nullable',
            'max_money' => 'required',
            'discount' => 'required',
            'expire_day' => 'required',
            'quality' => 'required',
            'point' => 'required',
            'description' => 'nullable',
            'dateRange' => 'nullable',
            'options' => [
                'required',
                new EnumValue(VoucherOptions::class)
            ],
            'type' => [
                'required',
                new EnumValue(VoucherType::class)
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
