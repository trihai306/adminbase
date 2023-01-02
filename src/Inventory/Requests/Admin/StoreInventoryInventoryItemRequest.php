<?php

namespace Modules\Inventory\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Modules\Core\Requests\FormRequest;
use Modules\Inventory\Enums\InventoryItemStatus;

class StoreInventoryInventoryItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => [
                'required',
                'array'
            ],
            'items.*' => 'string',
            'status' => new EnumValue(InventoryItemStatus::class)
        ];
    }
}
