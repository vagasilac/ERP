<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectQualityControlDrawing extends Model
{
    protected $fillable =  ['project_id', 'drawing_id', 'file_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }


}
