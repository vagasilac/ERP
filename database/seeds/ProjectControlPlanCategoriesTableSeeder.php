<?php

use App\Models\ProjectControlPlanCategory;
use Illuminate\Database\Seeder;

class ProjectControlPlanCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectControlPlanCategory::create(['id' => 1, 'name' => 'Aprovizionare']);
        ProjectControlPlanCategory::create(['id' => 2, 'name' => 'Debitare']);
        ProjectControlPlanCategory::create(['id' => 3, 'name' => 'Prelucrări mecanice']);
        ProjectControlPlanCategory::create(['id' => 4, 'name' => 'Pregătirea reperelor pentru sudare']);
        ProjectControlPlanCategory::create(['id' => 5, 'name' => 'Asamblare, heftuire']);
        ProjectControlPlanCategory::create(['id' => 6, 'name' => 'Sudare']);
        ProjectControlPlanCategory::create(['id' => 7, 'name' => 'Protecţia anticorosivă']);
        ProjectControlPlanCategory::create(['id' => 8, 'name' => 'Ambalare, expediere şi transport']);
    }
}
