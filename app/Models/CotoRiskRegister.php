<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoRiskRegister extends Model
{
    protected $fillable = ['id', 'coto_issue_id', 'process_id', 'risk_likelihood', 'risk_occurrences', 'risk_potential_loss_of_contracts', 'risk_potential_risk_to_human_health', 'risk_inability_to_meet_contract_terms', 'risk_potential_violation_of_regulations', 'risk_impact_on_company_reputation', 'risk_est_cost_of_correction', 'mitigation_likelihood', 'mitigation_occurrences', 'mitigation_potential_loss_of_contracts', 'mitigation_potential_risk_to_human_health', 'mitigation_inability_to_meet_contract_terms', 'mitigation_potential_violation_of_regulations', 'mitigation_impact_on_company_reputation', 'mitigation_est_cost_of_correction', 'mitigation_plan', 'risk_prob_rating', 'risk_cons_rating', 'before_risk_factor', 'mitigation_prob_rating', 'mitigation_cons_rating', 'after_risk_factor'];

    public $timestamps = false;

    /*
     * Get the process
     */
    function process() {
        return $this->belongsTo('App\Models\Process');
    }

    /**
     * Get documents.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\CotoRiskRegistersDocument', 'coto_risk_register_id')->orderBy('name');
    }
}
