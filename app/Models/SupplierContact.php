<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    protected $fillable =  ['name', 'email', 'phone'];

    /**
     * Get the supplier that owns the contact person.
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
