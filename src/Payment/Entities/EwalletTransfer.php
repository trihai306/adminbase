<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Casts\MediaFile;
use Modules\Payment\Enums\EwalletTransferStatus;

class EwalletTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'ewallet_id',
        'ref',
        'content',
        'amount',
        'transacted_at',
        'discount_rate',
        'receive_amount',
        'bill',
        'feedback',
        'status'
    ];

    protected $casts = [
        'amount' => 'integer',
        'transacted_at' => 'datetime',
        'bill' => MediaFile::class,
        'status' => EwalletTransferStatus::class
    ];

    public function ewallet()
    {
        return $this->belongsTo(Ewallet::class);
    }


    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\EwalletTransferFactory::new();
    }
}
