<?php

namespace Modules\Inbox\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender_id',
        'body'
    ];

    protected $casts = [
        'body' => 'array'
    ];

    public function scopeSearch(Builder $builder, $keyword)
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('body', 'like', "%$keyword%");
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    protected static function newFactory()
    {
        return \Modules\Inbox\Database\factories\MessageFactory::new();
    }
}
