<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoRiskRegistersDocument extends Model
{
    protected $fillable =  ['name', 'coto_risk_register_id', 'file_id'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
