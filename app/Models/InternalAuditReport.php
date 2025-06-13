<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditReport extends Model
{
    protected $fillable = ['internal_audit_id', 'auditor_id', 'documentation_suggestions', 'review_report_problems_discovered'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'internal_audit_report_audited', 'internal_report_id', 'role_id');
    }

    public function get_audited_people()
    {
        $names = '';

        foreach ($this->roles as $role) {
            $names .= $role->name . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }

    public function auditor()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function documentations()
    {
        return $this->hasMany('App\Models\InternalAuditReportDoc');
    }

    public function report_audits()
    {
        return $this->hasMany('App\Models\InternalAuditReportAudit', 'internal_audit_report_id');
    }

    public function review_reports()
    {
        return $this->hasMany('App\Models\InternalAuditReportReview');
    }
}
