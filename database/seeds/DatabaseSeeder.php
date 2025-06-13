<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesPermissionsTablesSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(SupplierTypesTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ProjectControlPlanCategoriesTableSeeder::class);
        $this->call(ProjectControlPlanItemsTableSeeder::class);

    }
}
