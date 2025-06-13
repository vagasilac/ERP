<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDrawingsRegister extends Model
{
    protected $fillable =  ['project_id', 'drawing_id', 'reception', 'reception_date', 'reception_user_id', 'distribution', 'distribution_date', 'distribution_user_id', 'collection', 'collection_date', 'collection_user_id'];

    protected $table = 'project_drawings_register';

    public $timestamps = false;
}
