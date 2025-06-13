<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditReportReview extends Model
{
    protected $fillable = ['internal_audit_report_id', 'review_report_question', 'review_report_yes_no', 'review_report_proof_or_note'];

    public $timestamps = false;
}
