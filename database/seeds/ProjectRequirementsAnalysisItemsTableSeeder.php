<?php

use App\Models\ProjectRequirementsAnalysisItem;
use Illuminate\Database\Seeder;

class ProjectRequirementsAnalysisItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectRequirementsAnalysisItem::create(['name' => 'Oferte, contracte și analize (ale proiectului/construcţiei)']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Cerinţe']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Documentaţia technică este disponibilă, completă şi verificată privind realizabilitatea']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Desenele pentru fabricaţie sunt disponibile']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Materii prime']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Materiale de adaos la sudare']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Elemente de îmbinare']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Cerinţele privind materialele de vopsire']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Controlul materialelor la recepţie']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Controlul producţiei în fabrică al componentelor construcţiei']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Sarcinile de montaj planificate']);
        ProjectRequirementsAnalysisItem::create(['name' => 'Termenenle sunt realizabile']);
    }
}
