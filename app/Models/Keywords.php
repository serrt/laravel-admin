<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    protected $fillable = ['id', 'type', 'key', 'name', 'sort'];

    public $timestamps = false;

    protected $table = 'keywords';

    public function keyType()
    {
        return $this->hasOne(KeywordsType::class, 'id', 'type');
    }
}
