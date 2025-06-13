<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterialStock extends Model
{
    protected $table = 'project_materials_stock';

    protected $fillable = ['quantity', 'pieces', 'material_id', 'standard_id', 'certificate_id', 'location'];

    /**
     * Get the material info.
     */
    public function material_info()
    {
        return $this->belongsTo('App\Models\SettingsMaterial', 'material_id');
    }

    /**
     * Get the standard.
     */
    public function standard()
    {
        return $this->belongsTo('App\Models\SettingsStandard');
    }

    /**
     * Get the standard.
     */
    public function certificate()
    {
        return $this->belongsTo('App\Models\SettingsStandard', 'certificate_id');
    }
}
