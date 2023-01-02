<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Casts\MediaFile;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'description'
    ];

    protected $casts = [
        'image' => MediaFile::class
    ];

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\OptionValueFactory::new();
    }
}
