<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Catalog\Enums\PromotionActionType;
use Modules\Catalog\Enums\PromotionScopeType;
use Modules\Catalog\Enums\PromotionStatus;
use Modules\Core\Scopes\StatusScope;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'scope_type',
        'action_type',
        'action_amount',
        'start_at',
        'end_at',
        'status'
    ];

    protected $casts = [
        'scope_type' => PromotionScopeType::class,
        'action_type' => PromotionActionType::class,
        'action_amount' => 'integer',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => PromotionStatus::class
    ];

    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(PromotionStatus::ACTIVATED));
        }
    }

    public function scopeInAvailableTime(Builder $builder, $time)
    {
        return $builder->where(function ($query) use ($time) {
                return $query->whereNull('start_at')
                    ->orWhere('start_at', '<=', $time);
            })
            ->where(function ($query) use ($time) {
                return $query->whereNull('end_at')
                    ->orWhere('end_at', '>=', $time);
            });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_product');
    }

    public function product_ids()
    {
        return $this->products()->select('id');
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\PromotionFactory::new();
    }
}
