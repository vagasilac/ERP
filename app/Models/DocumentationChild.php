<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentationChild extends Model
{
    protected $fillable = ['documentation_id', 'name', 'revision', 'date', 'type', 'link'];
}
