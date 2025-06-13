<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyReport extends Model
{
    protected $fillable = ['description', 'other_description', 'process_date', 'location', 'cause', 'consequenc', 'plan', 'take_action', 'intervention_team_plan', 'requirements_for_intervention', 'required_measures', 'responsibility_user_id', 'required_measures_deadlin', 'modify_the_emergency_plan', 'revision_responsible_emergency_plan', 'revision_responsible_emergency_plan_deadlin', 'elaborate_user_id', 'verified', 'verified_date_time', 'verified_user_id', 'approved', 'approved_date_time', 'approved_user_id'];

    /**
     * Get the responsibility user
     */
    public function responsibility()
    {
        return $this->belongsTo('App\Models\User', 'responsibility_user_id');
    }

    /**
     * Get the elaborate user
     */
    public function elaborate()
    {
        return $this->belongsTo('App\Models\User', 'elaborate_user_id');
    }

    /**
     * Get the verified user
     */
    public function verified_user()
    {
        return $this->belongsTo('App\Models\User', 'verified_user_id');
    }

    /**
     * Get the approved user
     */
    public function approved_user()
    {
        return $this->belongsTo('App\Models\User', 'approved_user_id');
    }
}
