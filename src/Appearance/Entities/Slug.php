<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Slug extends Model
{
    use HasFactory;

    protected $fillable = [
        'slugable_type',
        'slugable_id',
        'prefix',
        'slug',
        'keywords',
        'description'
    ];

    public function slugable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory()
    {
        return \Modules\Appearance\Database\factories\SlugFactory::new();
    }
}
