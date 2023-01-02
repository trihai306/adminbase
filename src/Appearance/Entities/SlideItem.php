<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Casts\MediaFile;

class SlideItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'url',
        'index'
    ];

    protected $casts = [
        'image' => MediaFile::class
    ];

    protected static function newFactory()
    {
        return \Modules\Appearance\Database\factories\SlideItemFactory::new();
    }
}
