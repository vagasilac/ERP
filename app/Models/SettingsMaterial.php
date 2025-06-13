<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingsMaterial extends Model
{
    protected $fillable =  ['name', 'G', 'AL', 'ml_6', 'ml_12', 'ml_12_1', 'DC01', 'S235', 'S275', 'S355', 'S460', 'DIN1025_1', 'DIN1025_5', 'EN10210_2', 'EN10210_3', 'EN10210_4', 'EN10210_5', 'EN10210_6', 'EN10210_7', 'Euronorm19_57', 'info', 'thickness', 'price', 'M', 'consumption', 'material_group', 'type', 'unit', 'coefficient'];

    public $timestamps = false;

    /**
     * Material in stock
     */
    public function in_stock()
    {
        return $this->hasMany('App\Models\ProjectMaterialStock', 'material_id');
    }

    /**
     * Return a material by name
     *
     * @param $name
     * @return null|mixed
     */
    public static function get_material_by_name($name)
    {
        $name = str_replace('-', '', str_replace(' ', '', $name));
        $materials = null;
        if ($name != '') {
            $materials = SettingsMaterial::select("*", DB::raw("REPLACE(REPLACE(name, ' ', ''), '-','') as name_without_whitespaces"))->havingRaw("name_without_whitespaces REGEXP '[" . $name . "]{" . strlen($name) . "}'")->get();
        }

        $name_chars = str_split($name);
        sort($name_chars);
        $name_alphabetically = implode('', $name_chars);
        if (!is_null($materials)) {
            foreach ($materials as $material) {
                $chars = str_split(str_replace(' ', '', $material->name));
                sort($chars);
                $material_name_alphabetically = implode('', $chars);

                if ($material_name_alphabetically == $name_alphabetically) {
                    return $material;
                }
            }
        }

        return null;
    }

    public function material_type()
    {
        switch ($this->type) {
            case 'main':
                if (is_null($this->thickness) || $this->thickness == 0) {
                    return 'profile';
                }
                else {
                    return 'plate';
                }
                break;
            default:
                return $this->type;
        }
    }
}
