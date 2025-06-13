<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRegisterDocument extends Model
{
    protected $fillable = ['contract_register_id', 'name', 'file_id'];

    public $timestamps = false;

    /*
    * Get the file.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
