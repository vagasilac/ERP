<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = ['id', 'name'];

    public $timestamps = false;

    public function sub_process()
    {
        return $this->hasMany('App\Models\SubProcess', 'process_id');
    }

    public function chapters()
    {
        return $this->belongsToMany('App\Models\StandardChapter', 'process_standard_chapters', 'process_id', 'chapter_id');
    }

    public function procedures()
    {
        return $this->belongsToMany('App\Models\StandardProcedure', 'process_standard_procedures', 'procedure_id', 'process_id');
    }

    public function get_chaptures_nrs_from_a_standard($id)
    {
        $nrs = '';

        $chapters = $this->chapters()->where('standard_id', $id)->get();

        foreach ($chapters as $chapter) {
            $nrs .= $chapter->chapter_nr . ', ';
        }

        $nrs = preg_replace('/,\s$/', '', $nrs);

        return $nrs;
    }

    public function get_procedure_names()
    {
        $names = '';

        foreach ($this->procedures as $procedure) {
            $names .= $procedure->name . ', ';
        }

        $names = preg_replace('/,\s$/', '', $names);

        return $names;
    }
}
