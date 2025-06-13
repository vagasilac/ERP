<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class MessageRoom extends Model
{
    protected $table = 'message_rooms';

    protected $fillable = ['name'];

    /**
     * Get room participants
     */
    public function participants(){
        return $this->hasMany('App\Models\MessageParticipant', 'message_room_id', 'id');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message')->orderBy('created_at', 'ASC');
    }

    public function lastMessage(){
        return $this->hasMany('App\Models\Message')->orderBy('created_at', 'DESC')->first();
    }

    public function users(){
        return $this->hasMany('App\Models\User');
    }

    public function seen(){
        return $this->hasMany('App\Models\MessageRead');
    }
}
