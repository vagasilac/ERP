<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementReviewProcess extends Model
{
    protected $fillable = ['management_review_id', 'process_id', 'purpose_of_the_process', 'process_objectives', 'current_status', 'target', 'realised'];

    public $timestamps = false;

    public function process()
    {
        return $this->belongsTo('App\Models\Process');
    }
}
