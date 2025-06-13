<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAuditProcess extends Model
{
    protected $fillable = ['internal_audit_id', 'process_id'];

    public function process()
    {
        return $this->belongsTo('App\Models\Process');
    }
}
