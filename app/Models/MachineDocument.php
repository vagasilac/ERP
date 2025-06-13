<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineDocument extends Model
{
    protected $fillable =  ['name', 'machine_id', 'file_id', 'type'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
