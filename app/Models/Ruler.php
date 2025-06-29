<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruler extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'inventory_number', 'measuring_range', 'user_id', 'photo'];


    /**
     * Set the equipment's measuring range.
     *
     * @param  string  $value
     * @return string
     */
    public function setMeasuringRangeAttribute($value)
    {
        $this->attributes['measuring_range'] = $value != '' ? $value : null;
    }

    /**
     * Set the equipment's photo.
     *
     * @param  string  $value
     * @return string
     */
    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = $value != '' ? $value : null;
    }

    /**
     * Set the equipment's user id.
     *
     * @param  string  $value
     * @return string
     */
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value != '' ? $value : null;
    }


    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
