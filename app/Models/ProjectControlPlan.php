<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectControlPlan extends Model
{
    protected $fillable =  ['project_id', 'item_id', 'date', 'status', 'user_id'];

    public $timestamps = false;
}
