<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAudit extends Model
{
    protected $fillable = ['audit', 'date_scheduled', 'date_conducted'];

    public function process()
    {
        return $this->hasMany('App\Models\InternalAuditProcess', 'internal_audit_id');
    }

    public function get_process_names()
    {
        $names = '';

        foreach ($this->process as $process) {
            $names .= $process->process->name . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }

    public function get_chapters_nrs($id)
    {
        $nrs = '';

        foreach ($this->process as $internal_process) {
            $chapters_object = $internal_process->process->chapters()->where('standard_id', $id)->get();
            foreach ($chapters_object as $chapter) {
                $nrs .= $chapter->chapter_nr . ', ';
            }

            foreach ($internal_process->process->sub_process as $sub_process) {
                $chapters_object = $sub_process->chapters()->where('standard_id', $id)->get();
                foreach ($chapters_object as $chapter) {
                    $nrs .= $chapter->chapter_nr . ', ';
                }
            }
        }

        $nrs = preg_replace('/,\s$/', '', $nrs);

        $nrs = implode(',    ', array_unique(explode(', ', $nrs)));

        return $nrs;
    }

    public function get_procedures($id)
    {
        $names = '';

        $internal_process_object = $this->process()->where('process_id', $id)->get();

        foreach ($internal_process_object as $internal_process) {
            foreach ($internal_process->process->procedures as $procedure) {
                $names .= $procedure->name . ', ';
            }

            foreach ($internal_process->process->sub_process as $sub_process) {
                foreach ($sub_process->procedures as $procedure) {
                    $names .= $procedure->name . ', ';
                }
            }
        }

        $names = preg_replace('/,\s$/', '', $names);

        $names = implode(', ',array_unique(explode(', ', $names)));

        return $names;
    }
}
