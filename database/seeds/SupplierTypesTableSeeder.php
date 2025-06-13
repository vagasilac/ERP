<?php

use App\Models\SupplierType;
use Illuminate\Database\Seeder;

class SupplierTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupplierType::create(['name' => 'Materii prime']);
        SupplierType::create(['name' => 'Materii auxiliare']);
        SupplierType::create(['name' => 'Consumabile']);
        SupplierType::create(['name' => 'Masini unelte']);
        SupplierType::create(['name' => 'Scule']);
        SupplierType::create(['name' => 'Echipamente de protectie']);
        SupplierType::create(['name' => 'Energie']);
        SupplierType::create(['name' => 'Birotica si IT']);
        SupplierType::create(['name' => 'Igiena']);
        SupplierType::create(['name' => 'Transport']);
    }
}
