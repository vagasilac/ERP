<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocumentCategory extends Model
{
    protected $fillable =  ['id', 'name', 'type'];

    public $timestamps = false;

    /**
     * Get the items for the category.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\ProjectDocument', 'category_id');
    }
}
