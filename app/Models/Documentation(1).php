<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $fillable = ['name', 'revision', 'date', 'type', 'link'];

    public function child()
    {
        return $this->hasMany('App\Models\DocumentationChild', 'documentation_id');
    }
}
