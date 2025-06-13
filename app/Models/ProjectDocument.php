<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    protected $fillable =  ['name', 'project_id', 'file_id', 'category_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

    public function project_document_categorie()
    {
        return $this->belongsTo('App\Models\ProjectDocumentCategory', 'category_id');
    }
}
