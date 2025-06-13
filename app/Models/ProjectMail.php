<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMail extends Model
{
    protected $fillable =  ['name', 'project_id', 'file_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
