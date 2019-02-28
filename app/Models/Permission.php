<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected $fillable = ['name', 'guard_name', 'display_name', 'pid'];

    protected $attributes = [
        'pid' => 0
    ];

    public function parent()
    {
        return $this->hasOne(Permission::class,'id', 'pid')->withDefault([
            'id' => null,
            'display_name' => ''
        ]);
    }

    public function children()
    {
        return $this->hasMany(Permission::class,'pid', 'id');
    }
}
