<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable =  ['name', 'email', 'phone'];

    /**
     * Get the customer that owns the contact person.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
