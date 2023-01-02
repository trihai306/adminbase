<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\OrderType;

class Inventory extends Variant
{
    use HasFactory;

    protected $table = 'variants';

    protected $fillable = [];

    protected static function booted()
    {
        static::addGlobalScope('order_type', function (Builder $builder) {
            $builder->where('order_type', OrderType::IMMEDIATE);
        });
    }

    public function items()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function available_items()
    {
        return $this->availableItems();
    }

    public function availableItems()
    {
        return $this->items()->available();
    }

    public function sold_items()
    {
        return $this->soldItems();
    }

    public function soldItems()
    {
        return $this->items()->sold();
    }
}
