<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectOrderConfirmation extends Model
{
    protected $fillable = ['project_id', 'name', 'file_id'];

    /*
    * Get the file.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
