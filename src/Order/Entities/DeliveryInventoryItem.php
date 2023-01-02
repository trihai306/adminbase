<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryInventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'inventory_item_id',
        'item'
    ];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\DeliveryInventoryItemFactory::new();
    }
}
