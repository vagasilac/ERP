<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCalculationsSetting extends Model
{
    protected $fillable =  ['id', 'name', 'type', 'value'];

    public $timestamps = false;
}
