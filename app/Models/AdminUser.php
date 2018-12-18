<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use HasRoles;

    protected $fillable = ['id', 'username', 'password', 'name', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $rememberTokenName = '';

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'user_menus', 'user_id', 'menu_id');
    }
}
