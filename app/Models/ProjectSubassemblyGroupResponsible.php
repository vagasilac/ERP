<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubassemblyGroupResponsible extends Model
{
    protected $fillable =  ['group_id', 'user_id'];

    public $timestamps = false;

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
