<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierToType extends Model
{
    protected $fillable = ['supplier_id', 'type_id'];

    public $timestamps = false;

}
