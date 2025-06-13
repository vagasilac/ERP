<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    protected $fillable =  ['address', 'city', 'county', 'country', 'supplier_id'];

    public $timestamps = false;
}
