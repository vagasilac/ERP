<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'inventory_no', 'source', 'manufacturing_year', 'type', 'power', 'observations', 'operation_id', 'maintenance_log', 'hourly_rate',  'photo'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set the machine's source.
     *
     * @param  string  $value
     * @return string
     */
    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = $value != '' ? $value : null;
    }

    /**
     * Set the machine's manufacturing year.
     *
     * @param  string  $value
     * @return string
     */
    public function setManufacturingYearAttribute($value)
    {
        $this->attributes['manufacturing_year'] = $value != '' ? $value : null;
    }

    /**
     * Set the machine's power.
     *
     * @param  string  $value
     * @return string
     */
    public function setPowerAttribute($value)
    {
        $this->attributes['power'] = $value != '' ? $value : null;
    }

    /**
     * Set the machine's power.
     *
     * @param  string  $value
     * @return string
     */
    public function setObservationAttribute($value)
    {
        $this->attributes['observation'] = $value != '' ? $value : null;
    }

    /**
     * Set the machine's power.
     *
     * @param  string  $value
     * @return string
     */
    public function setOperationIdAttribute($value)
    {
        $this->attributes['operation_id'] = $value != '' && $value != 0 ? $value : null;
    }


    /**
     * Get the machine's operation.
     */
    public function operation()
    {
        return $this->belongsTo('App\Models\ProjectCalculationsSetting', 'operation_id');
    }
}
