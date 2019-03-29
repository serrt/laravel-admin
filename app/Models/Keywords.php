<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    protected $fillable = ['id', 'type_id', 'type_key', 'name', 'sort'];

    public $timestamps = false;

    protected $table = 'keywords';

    public function type()
    {
        return $this->belongsTo(KeywordsType::class, 'type_id', 'id');
    }
}
