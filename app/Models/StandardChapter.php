<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardChapter extends Model
{
    protected $fillable = ['standard_id', 'chapter_nr', 'chapter_title'];

    public function standard()
    {
        return $this->belongsTo('App\Models\Standard');
    }

    public function sub_processes()
    {
        return $this->belongsToMany('App\Models\SubProcess', 'sub_process_standard_chapters','sub_process_id', 'standard_chapter_id');
    }

    public function processes()
    {
        return $this->belongsToMany('App\Models\Process', 'process_standard_chapters', 'chapter_id', 'process_id');
    }

    public function internal_audit_requirements()
    {
        return $this->belongsToMany('App\Models\InternalAuditReportAudit', 'internal_audit_requirements', 'chapter_id', 'internal_report_audit_id');
    }
}
