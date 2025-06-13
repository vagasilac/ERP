<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function chapters()
    {
        return $this->hasMany('App\Models\StandardChapter', 'standard_id');
    }
}
