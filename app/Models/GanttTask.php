<?php

namespace App\Models;

use App\Observers\GanttTaskObserver;
use Illuminate\Database\Eloquent\Model;

class GanttTask extends Model
{
    protected $fillable = ['text', 'operation', 'start_date', 'duration', 'progress', 'sortorder', 'parent', 'deadline', 'planned_start', 'planned_end', 'end_date', 'project_id'];

    public $timestamps = false;

    /**
     * Attach observers
     *
     */
    public static function boot()
    {
        parent::boot();

        GanttTask::observe(new GanttTaskObserver);
    }

    /**
     * Get the links for the task.
     */
    public function links()
    {
        return $this->hasMany('App\Models\GanttLink', 'source');
    }

}
