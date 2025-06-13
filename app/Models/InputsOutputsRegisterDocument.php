<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputsOutputsRegisterDocument extends Model
{
    protected $fillable =  ['name', 'io_register_id', 'file_id', 'type'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
