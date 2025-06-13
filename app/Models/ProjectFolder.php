<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFolder extends Model
{
    protected $fillable =  ['name', 'route_name'];

    public $timestamps = false;

    /**
     * Get folder status for a project
     *
     * @param $project_id
     * @return bool|string
     */
    public function status($project_id)
    {
        $folder_status = ProjectFolderStatus::where('project_id', $project_id)->where('folder_id', $this->id)->where('status', 'rejected')->first();

        if (!is_null($folder_status) > 0) {
            return 'rejected';
        }
        else {
            $folder_status = ProjectFolderStatus::where('project_id', $project_id)->where('folder_id', $this->id)->where('status', 'approved')->first();

            if (!is_null($folder_status) > 0) {
                return 'approved';
            }
            else {
                $folder_status = ProjectFolderStatus::where('project_id', $project_id)->where('folder_id', $this->id)->where('status', 'completed')->first();
                return !is_null($folder_status) > 0 ? 'completed' : false;
            }
        }
    }

    /**
     * Return info for a specified status (user, description, timestamps)
     *
     * @param $project_id
     * @param $status
     * @return mixed|null
     */
    public function status_info($project_id, $status)
    {
        $folder_status = ProjectFolderStatus::where('project_id', $project_id)->where('folder_id', $this->id)->where('status', $status)->get();

        return count($folder_status) > 0 ? $folder_status : null;
    }

    /**
     * Get the parent of the project.
     */
    public function	parent()
    {
        return $this->belongsTo('App\Models\ProjectFolder', 'parent');
    }

    /**
     * Get the children of the project.
     */
    public function	children()
    {
        return $this->hasMany('App\Models\ProjectFolder', 'parent');
    }
}
