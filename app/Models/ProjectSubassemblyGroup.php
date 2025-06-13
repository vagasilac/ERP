<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubassemblyGroup extends Model
{
    protected $fillable =  ['project_id', 'name'];

    public $timestamps = false;

    /**
     * Get the responsibles for the project.
     */
    public function responsibles()
    {
        return $this->hasMany('App\Models\ProjectSubassemblyGroupResponsible', 'group_id');
    }

    /**
     * Get the subassemblies.
     */
    public function assemblies()
    {
        return $this->hasMany('App\Models\ProjectSubassembly', 'group_id')->whereNull('parent_id');
    }

    /**
     * Get the subassemblies.
     */
    public function subassemblies()
    {
        return $this->hasMany('App\Models\ProjectSubassembly', 'group_id')->whereNotNull('parent_id');
    }

}
