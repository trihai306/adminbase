<?php

namespace Modules\Inventory\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Enums\InventoryItemStatus;

class UpdateInventoryItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inventory_id' => [
                'filled',
                new Exists(Inventory::class, 'id')
            ],
            'item' => 'filled',
            'status' => [
                'filled',
                new EnumValue(InventoryItemStatus::class)
            ]
        ];
    }
}
