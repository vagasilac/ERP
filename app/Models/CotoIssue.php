<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoIssue extends Model
{
    protected $fillable = ['id', 'coto_parties_id', 'issues_concern', 'bias', 'processes_id', 'priority', 'treatment_method', 'other_treatment_method', 'record_reference', 'user_id'];

    public $timestamps = false;

    /*
     * Get the coto_party
     */
    function coto_party()
    {
        return $this->belongsTo('App\Models\CotoParty', 'coto_parties_id');
    }

    /*
     * Get the process
     */
    function process()
    {
        return $this->belongsTo('App\Models\Process', 'processes_id');
    }

    /*
     * Get the user
     */
    function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
     * Get Coto risk register
     */
    function coto_risk_register()
    {
        return $this->hasMany('App\Models\CotoRiskRegister', 'coto_issue_id');
    }

    /*
     * Get Coto opportunity register
     */
    function coto_opportunity_register()
    {
        return $this->hasMany('App\Models\CotoOpportunityRegister', 'coto_issue_id');
    }
}
