<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputsOutputsRegister extends Model
{
    protected $table = 'inputs_outputs_register';

    protected $fillable = ['date', 'number', 'description', 'receiver', 'target', 'received_date', 'invoice_number', 'notice_number', 'user_id'];

    protected $dates = ['date', 'received_date'];

    public $timestamps = false;

    /**
     * Get documents.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\InputsOutputsRegisterDocument', 'io_register_id')->orderBy('name');
    }

    /**
     * Get user.
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
