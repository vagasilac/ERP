<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaResult extends Model
{
    protected $fillable = ['capa_id', 'user_id', 'result', 'notes_and_justification'];
}
