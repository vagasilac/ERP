<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubassembly extends Model
{
    protected $fillable =  ['project_id', 'drawing_id', 'group_id', 'name', 'description', 'quantity', 'parent_id'];

    public $timestamps = false;

    /**
     * Get the subassembly group.
     */
    public function group()
    {
        return $this->belongsTo('App\Models\ProjectSubassemblyGroup');
    }

    /**
     * Get the subassembly group.
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * Get the subassembly parts.
     */
    public function parts()
    {
        return $this->hasMany('App\Models\ProjectSubassemblyPart', 'subassembly_id')->orderBy('name');
    }

    /**
     * Get the time tracking
     */
    public function time_tracking()
    {
        return $this->hasMany('App\Models\ProjectTimeTracking', 'subassembly_id');
    }

    /**
     * Get the progress percentege of the project
     */
    public function progress_percentage()
    {
        //calcualte operations no
        $operation_labels_no = 0;
        if ($this->project->has_painting()) {
            $operation_labels_no = $operation_labels_no + 1;
        }
        if ($this->project->has_sanding()) {
            $operation_labels_no = $operation_labels_no + 1;
        }
        if ($this->project->has_welding()) {
            $operation_labels_no = $operation_labels_no + 2; //welding + quality control
        }
        if ($this->project->has_locksmithing()) {
            $operation_labels_no = $operation_labels_no + 2; //locksmithing + quality control
        }

        $by_operation = [];
        if (isset($this->time_tracking) && count($this->time_tracking) > 0) {
            foreach($this->time_tracking as $item) {
                $by_operation[$item->operation_slug]['completed_items_no'] = isset($by_operation[$item->operation_slug]) && isset($by_operation[$item->operation_slug]['completed_items_no']) ? $by_operation[$item->operation_slug]['completed_items_no'] + $item['completed_items_no'] : $item['completed_items_no'];
                $by_operation[$item->operation_slug]['in_process_item_percentage'] = intval($item['completed_items_no']);
            }
        }

        $percentage_sum = 0;
        foreach ($by_operation as $item) {
            $percentage_temp = ($item['completed_items_no'] + intval($item['completed_items_no'])/100) * 100 / intval($this->quantity);
            if ($percentage_temp > 100) $percentage_temp = 100;
            $percentage_sum = $percentage_sum + $percentage_temp;
        }

        return round($percentage_sum / ($operation_labels_no == 0 ? 1 : $operation_labels_no), 2);

    }

    /**
     * Get the subassembly parent.
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\ProjectSubassembly', 'parent_id');
    }

    /**
     * Get the subassembly children.
     */
    public function children()
    {
        return $this->hasMany('App\Models\ProjectSubassembly', 'parent_id')->orderBy('name');
    }

}
