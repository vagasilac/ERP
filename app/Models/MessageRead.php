<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRead extends Model
{
    protected $table = 'message_read';

    protected $fillable = ['message_id', 'user_id', 'message_room_id'];



}
