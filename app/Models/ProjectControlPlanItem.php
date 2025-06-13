<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectControlPlanItem extends Model
{
    protected $fillable =  ['id', 'name', 'frequency', 'measurement_tool', 'visual_control', 'performed_by', 'registered_in', 'category_id'];

    public $timestamps = false;
}
