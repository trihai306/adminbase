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

class UpdatePromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'filled',
                (new Unique(Promotion::class))->ignore($this->route('promotion'))
            ],
            'name' => 'filled',
            'scope_type' => [
                'filled',
                new EnumValue(PromotionScopeType::class)
            ],
            'product_ids' => [
                new RequiredIf($this->input('scope_type') == PromotionScopeType::PRODUCT),
                new Exists(Product::class, 'id')
            ],
            'action_type' => [
                'filled',
                new EnumValue(PromotionActionType::class)
            ],
            'action_amount' => [
                'filled',
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
                'filled',
                new EnumValue(PromotionStatus::class)
            ]
        ];
    }
}
