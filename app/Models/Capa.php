<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capa extends Model
{
    protected $fillable = ['id', 'type', 'supplier_id', 'source', 'other_source', 'process_id', 'other_process', 'priority', 'description', 'user_id'];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
     * Get the assignment
     */
    public function assignment()
    {
        return $this->hasOne('App\Models\CapaAssignment', 'capa_id');
    }

    /*
    * Get the process
     */
    public function process()
    {
        return $this->belongsTo('App\Models\Process');
    }

    public function result()
    {
        return $this->hasOne('App\Models\CapaResult', 'capa_id');
    }
}
