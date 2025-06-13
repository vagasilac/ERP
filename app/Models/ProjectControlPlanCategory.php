<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectControlPlanCategory extends Model
{
    protected $fillable =  ['id', 'name'];

    public $timestamps = false;

    /**
     * Get the items for the category.
     */
    public function items()
    {
        return $this->hasMany('App\Models\ProjectControlPlanItem', 'category_id');
    }
}
