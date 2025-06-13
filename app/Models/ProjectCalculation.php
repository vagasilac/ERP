<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCalculation extends Model
{
    protected $fillable =  ['project_id', 'data'];

    public $timestamps = false;

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
