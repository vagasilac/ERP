<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectOffer extends Model
{
    protected $table = 'project_offers';

    protected $fillable = ['project_id', 'status', 'project_material_id', 'date_stocked', 'supplier_id', 'date_ordered', 'date_received', 'order_number', 'offer_number'];

    public function offer_suppliers(){
        return $this->hasMany('App\Models\ProjectOfferSupplier', 'project_offer_id');
    }

    public function offer_suppliers_received(){
        return $this->offer_suppliers()->where('status', 'offer_received');
    }

    public function offer_supplier_accepted(){
        return $this->offer_suppliers()->where('status', 'request_accepted');
    }

    public function material(){
        return $this->belongsTo('App\Models\ProjectMaterial', 'project_material_id');
    }

    public function ioOrder(){
        return $this->belongsTo('App\Models\InputsOutputsRegister', 'order_number');
    }

    public function ioOffer(){
        return $this->belongsTo('App\Models\InputsOutputsRegister', 'offer_number');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }

    public function ctcFile(){
        return $this->belongsTo('App\Models\File', 'ctc_file');
    }
    
}
