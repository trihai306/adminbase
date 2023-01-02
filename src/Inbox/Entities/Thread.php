<?php

namespace Modules\Inbox\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Order\Entities\OrderItem;
use Modules\User\Entities\User;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'customer_id',
        'order_item_id'
    ];

    public function getLastSeenAtAttribute()
    {
        $currentParticipant = $this->participants()
            ->wherePivot('user_id', auth()->id())
            ->first();

        return $currentParticipant ? new Carbon($currentParticipant->pivot->last_seen_at) : null;
    }

    public function getUnseenMessagesCountAttribute()
    {
        $query = $this->messages();

        if ($this->last_seen_at) {
            $query->where('created_at', '>', $this->last_seen_at);
        }

        return $query->count();
    }

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('subject', 'like', "%$keyword%")
                ->orWhereHas('customer', function ($query) use ($keyword) {
                    return $query->search($keyword);
                });
        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latest_message()
    {
        return $this->latestMessage();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)
            ->latest();
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'thread_participant')
            ->withPivot('last_seen_at');
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function order_item()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    protected static function newFactory()
    {
        return \Modules\Inbox\Database\factories\ThreadFactory::new();
    }
}
