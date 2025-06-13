<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsStandard extends Model
{
    protected $table = 'settings_material_standards';

    protected $fillable =  ['EN', 'DIN_SEW', 'number'];

    public $timestamps = false;

    public function name()
    {
        return ($this->EN != '' && $this->EN != null) ? $this->EN : $this->DIN_SEW;
    }
}
