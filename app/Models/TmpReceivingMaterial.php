<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpReceivingMaterial extends Model
{
    protected $fillable = ['name', 'no_order', 'quality', 'amount', 'amount_kg', 'project', 'supplier', 'date_of_reception', 'opinion_or_invoice', 'amount_2_m', 'amount_2_kg', 'quality_certificate', 'certified_quality', 'sarja', 'internal_certificate_number'];

    public $timestaps = false;
}
