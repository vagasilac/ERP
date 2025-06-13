<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoOpportunityRegisterDocuments extends Model
{
    protected $fillable = ['id', 'coto_opp_reg_id', 'name', 'file_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
