<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected $fillable = ['id', 'name', 'guard_name', 'display_name', 'pid', 'menu_id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            if ($model->pid === null) {
                $model->pid = 0;
            }
        });

        static::updating(function ($model) {
            if ($model->pid === null) {
                $model->pid = 0;
            }
        });
    }

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

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id')->withDefault([
            'id' => null,
            'key' => '',
            'name' => ''
        ]);
    }
}
