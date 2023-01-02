<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Casts\MediaFile;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name'
    ];

    protected $casts = [
        'logo' => MediaFile::class
    ];

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\BrandFactory::new();
    }
}
