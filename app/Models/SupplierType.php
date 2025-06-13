<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierType extends Model
{
    protected $fillable =  ['name'];

    public $timestamps = false;

    /**
     * Get suppliers for the types
     */
    public function supplier()
    {
        return $this->hasMany('App\Models\SupplierToType', 'type_id');
    }
}
