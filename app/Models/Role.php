<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected $fillable = ['id', 'name', 'guard_name', 'display_name', 'created_at', 'updated_at'];
}
