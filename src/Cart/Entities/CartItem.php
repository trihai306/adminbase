<?php

namespace Modules\Cart\Entities;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Modules\Catalog\Enums\OrderType;
use Modules\Core\Entities\Model;
use Modules\Media\Casts\MediaFile;

class CartItem extends Model
{
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'variant_id',
        'code',
        'name',
        'image',
        'price',
        'discount_price',
        'sale_price',
        'quantity',
        'order_type'
    ];

    protected $casts = [
        'image' => MediaFile::class,
        'price' => 'integer',
        'discount_price' => 'integer',
        'sale_price' => 'integer',
        'quantity' => 'integer',
        'order_type' => OrderType::class
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge($attributes, [
            'id' => Str::uuid()
        ]));
    }

    public function getTotalAttribute()
    {
        return $this->sale_price * $this->quantity;
    }
}
