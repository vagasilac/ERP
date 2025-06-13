<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCutting extends Model
{
    protected $fillable =  ['name', 'description', 'project_id', 'file_id'];
    protected $table = 'project_cutting_drawings';

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
