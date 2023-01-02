<?php

namespace Modules\Inbox\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return \Modules\Inbox\Database\factories\NoteFactory::new();
    }
}
