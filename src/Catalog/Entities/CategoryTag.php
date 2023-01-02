<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function parent_categories()
    {
        return $this->belongsToMany(Category::class, 'children_category_tag');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_category_tag');
    }

    protected static function newFactory()
    {
        return \Modules\Catalog\Database\factories\CategoryTagFactory::new();
    }
}
