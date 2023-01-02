<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Scopes\StatusScope;
use Modules\Media\Casts\MediaFile;
use Modules\Payment\Enums\BankStatus;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'name',
        'image',
        'account_name',
        'account_number',
        'branch',
        'discount_rate',
        'index',
        'status'
    ];

    protected $casts = [
        'image' => MediaFile::class,
        'discount_rate' => 'integer',
        'status' => BankStatus::class
    ];

    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(BankStatus::ACTIVATED));
        }
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\BankFactory::new();
    }
}
