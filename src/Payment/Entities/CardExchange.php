<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Enums\CardType;

class CardExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'card_id',
        'type',
        'serial',
        'code',
        'value',
        'real_value',
        'discount_rate',
        'receive_amount',
        'feedback',
        'status'
    ];

    protected $casts = [
        'type' => CardType::class,
        'status' => CardExchangeStatus::class
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\CardExchangeFactory::new();
    }
}
