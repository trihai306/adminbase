<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Scopes\StatusScope;
use Modules\Media\Casts\MediaFile;
use Modules\Payment\Enums\CardStatus;
use Modules\Payment\Enums\CardType;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'type',
        'name',
        'image',
        'values',
        'discount_rate',
        'index',
        'status'
    ];

    protected $casts = [
        'type' => CardType::class,
        'image' => MediaFile::class,
        'values' => 'array',
        'discount_rate' => 'integer',
        'status' => CardStatus::class
    ];

    protected static function booted()
    {
        if (request()->isShopApi()) {
            static::addGlobalScope(new StatusScope(CardStatus::ACTIVATED));
        }
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\CardFactory::new();
    }
}
