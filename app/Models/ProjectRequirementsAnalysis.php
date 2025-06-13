<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequirementsAnalysis extends Model
{
    protected $fillable =  ['project_id', 'item_id', 'date', 'status', 'user_id', 'role_id'];

    protected $dates = ['date'];

    public $timestamps = false;

    /**
     * Get the user.
     */
    public function	user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
