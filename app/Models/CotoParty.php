<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotoParty extends Model
{
    protected $fillable = ['id', 'interested_party', 'int_ext', 'reason_for_inclusion'];
    public $timestamps = false;
}
