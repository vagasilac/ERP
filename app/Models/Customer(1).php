<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable =  ['name', 'short_name', 'company_number', 'vat_number', 'address', 'city', 'county', 'country', 'delivery_address', 'delivery_city', 'delivery_county', 'delivery_country', 'website', 'office_email', 'office_phone', 'logo'];

    /**
     * Get the contact persons for the customer.
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\CustomerContact');
    }

    /**
     * Get the projects for the customer
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
