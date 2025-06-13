<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageParticipant extends Model
{
    protected $table = 'message_participants';

    protected $fillable = ['message_room_id', 'user_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function room(){
        return $this->belongsTo('App\Models\MessageRoom');
    }
}
