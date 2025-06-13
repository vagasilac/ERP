<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable =  ['name', 'users_id', 'file_id', 'type', 'identity', 'diploma', 'family', 'employment_contract', 'job_description', 'decision', 'medical_record'];

    public $timestamps = false;

    /**
     * Get the file path.
     */
    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
