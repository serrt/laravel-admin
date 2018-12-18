<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['id', 'name', 'pid', 'key', 'url', 'sort', 'description'];

    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(Menu::class,'id', 'pid');
    }

    public function users()
    {
        return $this->belongsToMany(AdminUser::class, 'user_menus', 'menu_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class,'pid', 'id');
    }
}
