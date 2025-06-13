<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRating extends Model
{
    protected $fillable =  ['supplier_id', 'user_id', 'order_number'];

    /**
     * Set the rating's order number.
     *
     * @param  string  $value
     * @return string
     */
    public function setOrderNumberAttribute($value)
    {
        $this->attributes['order_number'] = $value != '' ? $value : null;
    }

    public function options() {
        return $this->belongsToMany('App\Models\SupplierRatingOption', 'supplier_rating_to_option', 'rating_id', 'option_id')->withPivot('value');
    }

    /**
     * Get the rating's user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
