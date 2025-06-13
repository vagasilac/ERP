<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\UserDocument;

class Participant extends Model
{
    protected $fillable = ['education_id', 'user_id', 'user_confirmed'];

    /*
    * Get education
     */
    function education()
    {
        return $this->belongsTo('App\Models\Education');
    }

    /*
    * Get diploma
     */
    public function diploma()
    {
        return UserDocument::where('users_id', $this->user_id)->where('type', 'diploma')->get();
    }

    /*
    * Get user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
