<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubassemblyPart extends Model
{
    protected $fillable =  ['name', 'quantity', 'project_id', 'subassembly_name', 'subassembly_id', 'material_name', 'material_id', 'standard_name', 'standard_id', 'length', 'width'];

    public $timestamps = false;

    protected $with = ['material', 'standard'];

    /**
     * Get the material.
     */
    public function material()
    {
        return $this->belongsTo('App\Models\SettingsMaterial');
    }

    /**
     * Get the standard.
     */
    public function standard()
    {
        return $this->belongsTo('App\Models\SettingsStandard');
    }

    /**
     * Get the subassembly.
     */
    public function subassembly()
    {
        return $this->belongsTo('App\Models\ProjectSubassembly');
    }

}
