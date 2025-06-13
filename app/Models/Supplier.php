<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable =  ['name', 'short_name', 'company_number', 'vat_number', 'address', 'city', 'county', 'country', 'website', 'office_email', 'office_phone', 'logo'];

    /**
     * Get the contact persons for the supplier.
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\SupplierContact');
    }

    /**
     * Get the addresses for the supplier.
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\SupplierAddress');
    }

    /**
     * Get the ratings for the supplier.
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\SupplierRating');
    }

    /**
     * Get types ids for the suppliers
     */
    public function types()
    {
        return $this->hasMany('App\Models\SupplierToType');
    }

    /**
     * Determine if the supplier has the given type.
     *
     * @param $type
     * @return mixed
     */
    public function hasType($type)
    {
        if (is_string($type)) {
            return SupplierType::where('name', $type)->first()
                ->supplier->contains('supplier_id', $this->id);
        }
        return SupplierType::findOrFail($type)
            ->supplier->contains('supplier_id', $this->id);
    }
}
