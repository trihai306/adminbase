<?php

namespace Modules\Inventory\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Enums\InventoryItemStatus;

class StoreInventoryItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inventory_id' => [
                'required',
                new Exists(Inventory::class, 'id')
            ],
            'item' => [
                'required',
                'string'
            ],
            'status' => new EnumValue(InventoryItemStatus::class)
        ];
    }
}
