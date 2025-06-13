<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['message', 'message_room_id', 'user_id'];


    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function room(){
        return $this->belongsTo('App\Models\MessageRoom');
    }

    public function seen($user_id){
        return $this->hasOne('App\Models\MessageRead')->where('user_id', '=', $user_id);
    }

    public function prevMessage(){

        $prevMessage = self::where('message_room_id', $this->message_room_id)->where('created_at', '<', $this->created_at)->orderBy('id', 'DESC')->first();

        if(!is_null($prevMessage)){
            return $prevMessage;
        }
        else{
            return false;
        }

    }


}
