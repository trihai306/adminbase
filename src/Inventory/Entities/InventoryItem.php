<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Enums\InventoryItemStatus;
use Modules\Inventory\Enums\InventoryItemType;
use Modules\User\Entities\User;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'item',
        'importer_id',
        'status'
    ];

    protected $casts = [
        'type' => InventoryItemType::class,
        'item' => 'encrypted:array',
        'status' => InventoryItemStatus::class
    ];

    public function scopeAvailable(Builder $builder)
    {
        return $builder->where('status', InventoryItemStatus::AVAILABLE);
    }

    public function scopeSold(Builder $builder)
    {
        return $builder->where('status', InventoryItemStatus::SOLD);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function importer()
    {
        return $this->belongsTo(User::class, 'importer_id');
    }

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\InventoryItemFactory::new();
    }
}
