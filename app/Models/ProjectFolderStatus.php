<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFolderStatus extends Model
{
    protected $fillable =  ['folder_id', 'project_id', 'user_id', 'status'];
    protected $table = 'project_folders_status';


    /**
     * Get the folder
     */
    public function folder()
    {
        return $this->belongsTo('App\Models\ProjectFolder');
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
