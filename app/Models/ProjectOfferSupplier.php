<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectOfferSupplier extends Model
{
    protected $table = 'project_offer_supplier';

    protected $fillable = ['project_offer_id', 'status', 'supplier_id', 'price', 'offer_received_at', 'offer_received_number', 'offer_number', 'offer_file'];

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }

    public function offer(){
        return $this->belongsTo('App\Models\ProjectOffer', 'project_offer_id');
    }

    public function fileOffer(){
        return $this->belongsTo('App\Models\File', 'offer_file');
    }
}
