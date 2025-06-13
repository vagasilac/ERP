<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditReportDoc extends Model
{
    protected $fillable = ['internal_audit_report_id', 'documentation_question', 'documentation_yes_no', 'documentation_proof_or_note'];

    public $timestamps = false;

    protected $table = 'internal_audit_report_doc';
}
