<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditReportAudit extends Model
{
    protected $fillable = ['internal_audit_report_id', 'audit_question', 'audit_yes_no', 'audit_proof_or_note'];

    public $timestamps = false;

    public function requirements()
    {
        return $this->belongsToMany('App\Models\StandardChapter', 'internal_audit_requirements', 'internal_report_audit_id', 'chapter_id');
    }

    public function requirements_name()
    {
        $names = '';

        foreach ($this->requirements as $requirement) {
            $names .= $requirement->chapter_title . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }
}
