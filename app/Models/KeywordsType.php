<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordsType extends Model
{
    protected $fillable = ['id', 'key', 'name'];

    public $timestamps = false;

    protected $table = 'keywords_type';

    public function keywords()
    {
        return $this->hasMany(Keywords::class, 'type', 'id');
    }
}
