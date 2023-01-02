<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Catalog\Enums\VoucherStatus;
use Modules\Catalog\Enums\VoucherType;
use Modules\Core\Scopes\StatusScope;
use Modules\User\Entities\User;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => VoucherStatus::class,
        'type' => VoucherType::class,
    ];
    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword){
            $query->where('name','like',"%$keyword%");
            $query->orWhere('code','like',"%$keyword%");
            $query->orWhere('point','like',"%$keyword%");
            $query->orWhere('quality','like',"%$keyword%");
        });
    }
    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(VoucherStatus::ACTIVATED));
        }
    }

    public function variants(): belongsToMany
    {
        return $this->belongsToMany(Variant::class, 'variant_voucher', 'voucher_id', 'variant_id');
    }
    public function variant_ids(): belongsToMany
    {
        return $this->variants()->select('variant_id');
    }

    public function user_ids(): belongsToMany
    {
        return $this->users()->select('user_id');
    }

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'user_voucher', 'voucher_id', 'user_id');
    }

    public function usersBy(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'user_by_voucher', 'user_id', 'voucher_id');
    }

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_voucher', 'voucher_id', 'product_id');
    }

    public function product_ids(): belongsToMany
    {
        return $this->products()->select('product_id');
    }
}
