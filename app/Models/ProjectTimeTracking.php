<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTimeTracking extends Model
{
    protected $table = 'project_time_tracking';
    protected $fillable =  ['project_id', 'type', 'subassembly_id', 'completed_items_no', 'in_process_item_percentage', 'operation_name', 'operation_slug', 'user_id'];
}
