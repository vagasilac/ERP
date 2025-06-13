<?php

use App\Models\ProjectFolder;
use Illuminate\Database\Seeder;

class ProjectFoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectFolder::create(['id' => 1, 'name' => 'Informații generale', 'route_name' => 'projects.general', 'order' => 1]);
        ProjectFolder::create(['id' => 2, 'name' => 'Foaie de date', 'route_name' => 'projects.datasheet', 'order' => 2]);
        ProjectFolder::create(['id' => 3, 'name' => 'Calcul', 'route_name' => 'projects.calculation', 'order' => 3]);
        ProjectFolder::create(['id' => 4, 'name' => 'Cerere de ofertă', 'route_name' => 'projects.rfq', 'order' => 4]);
        ProjectFolder::create(['id' => 5, 'name' => 'Contract', 'route_name' => 'projects.contract', 'order' => 5]);
        ProjectFolder::create(['id' => 6, 'name' => 'Debitare', 'route_name' => 'projects.cuttings', 'order' => 6]);
        ProjectFolder::create(['id' => 7, 'name' => 'Desene', 'route_name' => 'projects.drawings', 'order' => 7]);
        ProjectFolder::create(['id' => 8, 'name' => 'Desene CTC', 'route_name' => 'projects.drawings_qa', 'order' => 8]);
        ProjectFolder::create(['id' => 9, 'name' => 'Facturi', 'route_name' => 'projects.invoices', 'order' => 9]);
        ProjectFolder::create(['id' => 10, 'name' => 'Plan control', 'route_name' => 'projects.control_plan', 'order' => 10]);
        ProjectFolder::create(['id' => 11, 'name' => 'Registru desene', 'route_name' => 'projects.drawings_register', 'order' => 11]);
        ProjectFolder::create(['id' => 12, 'name' => 'Termene', 'route_name' => 'projects.terms', 'order' => 12]);
        ProjectFolder::create(['id' => 13, 'name' => 'Transport', 'route_name' => 'projects.transport', 'order' => 13]);
    }
}
