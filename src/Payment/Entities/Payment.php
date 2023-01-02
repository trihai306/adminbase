<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Enums\PaymentType;
use Modules\User\Entities\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer_id',
        'type',
        'order_id',
        'method_id',
        'method_type',
        'amount',
        'discount_rate',
        'receive_amount',
        'expire_at',
        'feed_back',
        'status'
    ];

    protected $casts = [
        'type' => PaymentType::class,
        'method_type' => PaymentMethodType::class,
        'expire_at' => 'datetime',
        'status' => PaymentStatus::class
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where('id', 'like', $keyword);
    }

    public function isExpired()
    {
        return now()->gt($this->expire_at);
    }

    public function canCancel($userId = null): bool
    {
        return ($this->payer_id == $userId || $userId == null) &&
            $this->status->value === PaymentStatus::PENDING;
    }

    public function canComplete(): bool
    {
        return $this->status->value === PaymentStatus::PENDING;
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function card_exchanges()
    {
        return $this->cardExchanges();
    }

    public function cardExchanges()
    {
        return $this->hasOne(CardExchange::class);
    }

    public function bank_transfer()
    {
        return $this->bankTransfer();
    }

    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class);
    }

    public function ewallet_transfer()
    {
        return $this->hasOne(EwalletTransfer::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\PaymentFactory::new();
    }
}
