<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Catalog\Entities\Review;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\OrderType;
use Modules\Media\Casts\MediaFile;
use Modules\Order\Enums\OrderItemStatus;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'variant_id',
        'code',
        'name',
        'image',
        'price',
        'discount_price',
        'sale_price',
        'quantity',
        'order_type',
        'feedback',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
        'image' => MediaFile::class,
        'order_type' => OrderType::class,
        'status' => OrderItemStatus::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('id', 'like', "%$keyword%")
                ->orWhere('code', 'like', "%$keyword%")
                ->orWhere('name', 'like', "%$keyword%");
        });
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function shouldDeliverImmediate()
    {
        return $this->order_type->value === OrderType::IMMEDIATE;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function deliveryInventoryItems()
    {
        return $this->delivery_inventory_items();
    }

    public function delivery_inventory_items()
    {
        return $this->hasMany(DeliveryInventoryItem::class);
    }

    public function rating()
    {
        return $this->hasOne(Review::class);
    }

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderItemFactory::new();
    }
}
