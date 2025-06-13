<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProcess extends Model
{
    protected $fillable = ['process_id', 'name'];

    public function process()
    {
        return $this->belongsTo('App\Models\Process');
    }

    public function chapters()
    {
        return $this->belongsToMany('App\Models\StandardChapter', 'sub_process_standard_chapters', 'sub_process_id', 'standard_chapter_id');
    }

    public function procedures()
    {
        return $this->belongsToMany('App\Models\StandardProcedure', 'sub_process_standard_procedures', 'sub_process_id', 'procedure_id');
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
}
