<?php

namespace Modules\Appearance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

class MenuItem extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = [
        'menu_id',
        'icon',
        'name',
        'url',
        'index'
    ];

    protected static function newFactory()
    {
        return \Modules\Appearance\Database\factories\MenuItemFactory::new();
    }
}
