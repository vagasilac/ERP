<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaPlan extends Model
{
    protected $fillable = ['capa_id', 'root_cause_of_problem', 'action_plan', 'user_id'];
}
