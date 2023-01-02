<?php

namespace Modules\Catalog\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\Rules\Unique;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Promotion;
use Modules\Catalog\Enums\PromotionActionType;
use Modules\Catalog\Enums\PromotionScopeType;
use Modules\Catalog\Enums\PromotionStatus;
use Modules\Core\Requests\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                new Unique(Promotion::class)
            ],
            'name' => 'required',
            'scope_type' => [
                'required',
                new EnumValue(PromotionScopeType::class)
            ],
            'product_ids' => [
                new RequiredIf($this->input('scope_type') == PromotionScopeType::PRODUCT),
                new Exists(Product::class, 'id')
            ],
            'action_type' => [
                'required',
                new EnumValue(PromotionActionType::class)
            ],
            'action_amount' => [
                'required',
                'integer',
                'min:0'
            ],
            'start_at' => [
                'nullable',
                'date'
            ],
            'end_at' => [
                'nullable',
                'date'
            ],
            'status' => [
                'required',
                new EnumValue(PromotionStatus::class)
            ]
        ];
    }
}
