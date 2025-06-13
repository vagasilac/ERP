<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRegister extends Model
{
    protected $fillable = ['nr_date_of_contract', 'supplier_id', 'customer_id', 'content', 'user_id'];

    /*
    * Get the supplier.
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    /*
    * Get the customer.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    /*
    * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
