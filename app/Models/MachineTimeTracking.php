<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineTimeTracking extends Model
{
//    protected $fillable =  ['machine_id', 'operation', 'frequency', 'type', 'note', 'supplier_id', 'user_id'];
    protected $fillable =  ['machine_id', 'operation', 'frequency', 'type', 'note', 'supplier_id', 'user_id', 'created_at', 'updated_at']; // @TODO Peter: remove
    protected $table = 'machine_time_tracking';
    public $timestamps = false; // @TODO Peter: remove

    /**
     * Get the machine.
     */
    public function machine()
    {
        return $this->belongsTo('App\Models\Machine');
    }
}
