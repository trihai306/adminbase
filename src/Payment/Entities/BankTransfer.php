<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Casts\MediaFile;
use Modules\Payment\Enums\BankTransferStatus;

class BankTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'bank_id',
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
        'status' => BankTransferStatus::class
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\BankTransferFactory::new();
    }
}
