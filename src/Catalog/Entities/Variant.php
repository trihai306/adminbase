<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Catalog\Enums\OrderType;
use Modules\Catalog\Enums\StockStatus;
use Modules\Inventory\Entities\InventoryItem;
use Modules\Media\Casts\MediaFile;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'name',
        'image',
        'price',
        'discount_price',
        'order_type',
        'stock_status',
        'is_default'
    ];

    protected $casts = [
        'image' => MediaFile::class,
        'price' => 'integer',
        'sale_price' => 'integer',
        'order_type' => OrderType::class,
        'stock_status' => StockStatus::class,
        'is_default' => 'boolean'
    ];

    public function getSalePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->discount_price === null) {
            return null;
        }

        return round(100 - 100 * $this->discount_price / $this->price);
    }

    public function isInStock($quantity = 1)
    {
        if ($this->order_type->value === OrderType::IMMEDIATE) {
            return $this->stock_status->value === StockStatus::IN_STOCK &&
                $this->available_inventory_items()->count() >= $quantity;
        }

        return $this->stock_status->value === StockStatus::IN_STOCK;
    }

    public function isOutOfStock($quantity = 1)
    {
        return !$this->isInStock($quantity);
    }

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('name', 'like', "%$keyword%");
    }

    public function scopeDefault(Builder $builder, $isDefault = true)
    {
        return $builder->where('is_default', $isDefault);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function option_value_ids()
    {
        return $this->optionValues()->select('id');
    }

    public function option_values()
    {
        return $this->optionValues();
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class, 'variant_option_value');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'variant_attribute');
    }

    public function available_inventory_items()
    {
        return $this->inventory_items()->available();
    }

    public function inventory_items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id');
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\VariantFactory::new();
    }
}
