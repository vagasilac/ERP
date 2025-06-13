<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyReportCommission extends Model
{
    protected $fillable = ['user_id', 'emergency_report_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
