<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Scopes\StatusScope;
use Modules\Media\Casts\MediaFile;
use Modules\Payment\Enums\PaymentMethodStatus;
use Modules\Payment\Enums\PaymentMethodType;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'code',
        'name',
        'image',
        'description',
        'config',
        'checkout_enabled',
        'recharge_enabled',
        'status'
    ];

    protected $casts = [
        'type' => PaymentMethodType::class,
        'image' => MediaFile::class,
        'config' => 'array',
        'status' => PaymentMethodStatus::class
    ];

    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(PaymentMethodStatus::ACTIVATED));
        }
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function ewallets()
    {
        return $this->hasMany(Ewallet::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\PaymentMethodFactory::new();
    }
}
