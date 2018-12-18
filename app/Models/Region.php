<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['pid', 'name', 'level', 'code'];

    public function parent()
    {
        return $this->hasOne(Region::class, 'id', 'pid');
    }
}
