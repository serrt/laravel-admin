<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['id', 'permission_name', 'name', 'pid', 'key', 'url', 'sort', 'description'];

    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(Menu::class,'id', 'pid');
    }

    public function children()
    {
        return $this->hasMany(Menu::class,'pid', 'id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_name', 'name');
    }
}
