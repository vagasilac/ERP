<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterial extends Model
{
    protected $fillable =  ['project_id', 'material_id', 'standard_id', 'quantity', 'pieces', 'certificate_id', 'size', 'net_size', 'material_no', 'net_quantity', 'sort'];

    public $timestamps = false;

    /**
     * Get the  q.
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function project_deadline(){
        return date('d-m-Y', strtotime('-1 DAY', strtotime($this->project->deadline)));
    }

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

    /**
     * Get material status/offer
     */
    public function offer(){
        return $this->hasOne('App\Models\ProjectOffer', 'project_material_id');
    }
}
