<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandardProcedure extends Model
{
    protected $fillable = ['name'];

    public function sub_processes()
    {
        return $this->belongsToMany('App\Models\SubProcess', 'sub_process_standard_procedures', 'procedure_id', 'sub_process_id');
    }

    public function processes()
    {
        return $this->belongsToMany('App\Models\Process', 'process_standard_procedures', 'process_id', 'procedure_id');
    }
}
