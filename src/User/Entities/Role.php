<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{
    public function scopeSearch(Builder $builder, $keyword): Builder
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('name', 'like', "%$keyword%")
                ->orWhere('display_name', 'like', "%$keyword%");
        });
    }

    public function permission_ids()
    {
        return $this->permissions()->select('id');
    }
}
