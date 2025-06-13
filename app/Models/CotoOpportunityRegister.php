<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoOpportunityRegister extends Model
{
    public $timestamps = false;

    protected $fillable = ['process_id', 'coto_issue_id', 'likelihood', 'occurrences', 'prob_rating', 'potential_for_new_business', 'potential_expansion_of_current_business', 'potential_improvement_in_satisfying_regulations', 'potential_improvement_to_internal_qms_processes', 'improvement_to_company_reputation', 'potential_cost_of_implementation', 'ben_rating', 'opp_factor', 'opportunity_pursuit_plan', 'post_implementation_success', 'status'];

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
        return $this->hasMany('App\Models\CotoOpportunityRegisterDocuments', 'coto_opp_reg_id')->orderBy('name');
    }
}
