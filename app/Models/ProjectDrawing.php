<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDrawing extends Model
{
    protected $fillable =  ['project_id', 'name', 'description', 'file_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    /**
     * Get the quality control drawings for the project.
     */
    public function quality_control_drawings()
    {
        return $this->hasMany('App\Models\ProjectQualityControlDrawing', 'drawing_id');
    }

    /**
     * Get the subassembly.
     */
    public function subassembly()
    {
        return $this->hasOne('App\Models\ProjectSubassembly', 'drawing_id');
    }


}
