<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaAssignment extends Model
{
    protected $fillable = ['capa_id', 'user_id', 'respond'];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
