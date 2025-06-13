<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementReviewMeeting extends Model
{
    protected $fillable = ['accepted_policy', 'policy_recommendation', 'accepted_issues', 'issues_recommendation', 'audit_note', 'infrastructure', 'qms', 'hr', 'education_note', 'customer_feedback_note', 'integrated_management_system_note'];

    public function absents()
    {
        return $this->belongsToMany('App\Models\Role', 'management_review_absents', 'management_review_id', 'role_id');
    }

    public function attendances()
    {
        return $this->belongsToMany('App\Models\Role', 'management_review_attendances', 'management_review_id', 'role_id');
    }

    public function get_absent_names()
    {
        $names = '';

        foreach ($this->absents as $absent) {
            $names .= $absent->name . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }

    public function get_attendance_names()
    {
        $names = '';

        foreach ($this->attendances as $attendance) {
            $names .= $attendance->name . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }

    public function management_review_processes()
    {
        return $this->hasMany('App\Models\ManagementReviewProcess', 'management_review_id');
    }
}
