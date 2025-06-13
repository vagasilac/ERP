<?php

use App\Models\ProjectControlPlanItem;
use Illuminate\Database\Seeder;

class ProjectControlPlanItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectControlPlanItem::create(['id' => 1, 'name' => 'Calitate, dimensiune, geometrie materialelor', 'frequency' => 'Fiecare buc.', 'measurement_tool' => 'Șubler, ruletă, echer', 'visual_control' => '', 'performed_by' => 'Aprovizionare, CTC-ist', 'registered_in' => 'F-06-07', 'category_id' => '1']);
        ProjectControlPlanItem::create(['id' => 2, 'name' => 'Cotele de pe desenul de execuţie', 'frequency' => 'Primele 5 buc 100%; în timpul fabricaţiei 10%', 'measurement_tool' => 'Șubler, ruletă', 'visual_control' => 'Calitatea suprafeţei tăiate', 'performed_by' => 'Operator, CTC-ist', 'registered_in' => 'F-02-03', 'category_id' => '2']);
        ProjectControlPlanItem::create(['id' => 3, 'name' => 'Duritatea zonei încălzite', 'frequency' => 'Validări la perioade de 3 luni, ale procesului de debitare cu flacără', 'measurement_tool' => 'Poldi', 'visual_control' => '', 'performed_by' => 'Şef comp. Controlul producţiei în fabrică', 'registered_in' => 'Buletin de verificare', 'category_id' => '2']);
        ProjectControlPlanItem::create(['id' => 4, 'name' => 'Perpendicularitatea tăierii', 'frequency' => 'Primele 5 buc 100%; în timpul fabricaţiei 10%', 'measurement_tool' => 'Echer', 'visual_control' => 'Calitatea suprafeţei tăiate', 'performed_by' => 'Operator, CTC-ist', 'registered_in' => 'Buletin de verificare', 'category_id' => '2']);
        ProjectControlPlanItem::create(['id' => 5, 'name' => 'Toate cotele indicate pe desen cu deosebită atenţie la D ext. şi int. al flanşelor, la poziţia găurilor şi la dimensiunile canalelor pentru garnitura de etanşare', 'frequency' => 'Fiecare buc.', 'measurement_tool' => 'Șubler, şubler de adâncime, compas, ceas comparator, riglă,raportor', 'visual_control' => 'Calitatea suprafeţei', 'performed_by' => 'Operator, personal CTC', 'registered_in' => 'F-02-03', 'category_id' => '3']);
        ProjectControlPlanItem::create(['id' => 6, 'name' => 'Cotele referitoare la şanfrenare şi alte forme de pregătire a rădăcinii', 'frequency' => 'Fiecare buc.', 'measurement_tool' => 'Șubler, şubler de adâncime, compas, riglă', 'visual_control' => 'Calitatea suprafeţei', 'performed_by' => 'Operator, personal CTC', 'registered_in' => 'F-02-03', 'category_id' => '4']);
        ProjectControlPlanItem::create(['id' => 7, 'name' => 'Toate cotele indicate pe desenul de ansamblu sau subansamblu', 'frequency' => 'La fiecare ansamblu sau subansamblu', 'measurement_tool' => 'Ruletă, şubler, echer, riglă, raportor', 'visual_control' => 'Calitatea pregătirii reperelor', 'performed_by' => 'Şef de echipă, personal CTC', 'registered_in' => 'F-02-03', 'category_id' => '5']);
        ProjectControlPlanItem::create(['id' => 8, 'name' => 'Verificarea valabilităţii WPS', 'frequency' => 'La fiecare subansamblu', 'measurement_tool' => '', 'visual_control' => 'da', 'performed_by' => 'IWP', 'registered_in' => 'Protocol de sudare', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 9, 'name' => 'Verificarea materialelor de adaos', 'frequency' => 'La fiecare subansamblu', 'measurement_tool' => '', 'visual_control' => 'da', 'performed_by' => 'IWP', 'registered_in' => 'Protocol de sudare', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 10, 'name' => 'Forma şi dimensiunile cordonului', 'frequency' => 'Fiecare cordon', 'measurement_tool' => 'Şubler de verif. cordon', 'visual_control' => 'Conform instrucţiunilor VT', 'performed_by' => 'IWP, CTC-ist, control VT2', 'registered_in' => 'Protocol de sudare, Raport de examinare VT', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 11, 'name' => 'Curăţirea după sudare', 'frequency' => 'Fiecare cordon', 'measurement_tool' => '', 'visual_control' => 'Conform instrucţiunilor VT', 'performed_by' => 'IWP, CTC-ist, control VT2', 'registered_in' => 'Protocol de sudare, Raport de examinare VT', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 12, 'name' => 'Verificarea deformaţiilor', 'frequency' => 'Fiecare subansamblu', 'measurement_tool' => 'Riglă, şubler', 'visual_control' => 'da', 'performed_by' => 'Sudor, CTC-ist', 'registered_in' => '', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 13, 'name' => 'Efectuarea examinărilor nedistructive', 'frequency' => 'Conform instrucţiunilor privind VT şi PT', 'measurement_tool' => 'Degresant, lichid penetrant, developant', 'visual_control' => 'Conform instrucţiunilor privind VT', 'performed_by' => 'Sudor, IWP,personal VT şi PT', 'registered_in' => 'Protocol de sudare, Raport de examinare VT', 'category_id' => '6']);
        ProjectControlPlanItem::create(['id' => 14, 'name' => 'Calitatea suprafeţei pregătite pentru vopsire', 'frequency' => '100%', 'measurement_tool' => '', 'visual_control' => 'da', 'performed_by' => 'Vopsitor', 'registered_in' => 'F-02-04-1', 'category_id' => '7']);
        ProjectControlPlanItem::create(['id' => 15, 'name' => 'Verificarea conformităţii vopselei (tip, şarjă)', 'frequency' => '100%', 'measurement_tool' => '', 'visual_control' => 'da', 'performed_by' => 'Vopsitor', 'registered_in' => 'F-02-04-1', 'category_id' => '7']);
        ProjectControlPlanItem::create(['id' => 16, 'name' => 'Verificarea aspectului suprafeţei vopsite, şi a grosimii stratului aplicat', 'frequency' => '100%', 'measurement_tool' => 'elcometru   ', 'visual_control' => 'da', 'performed_by' => 'Vopsitor, CTC-ist', 'registered_in' => 'F-02-04-1', 'category_id' => '7']);
        ProjectControlPlanItem::create(['id' => 17, 'name' => 'Folosirea paletilor , lăzilor si ambalajelor adecvate prevenirii deteriorării produsului în timpul transportului. Fixarea corectă a încărcăturii', 'frequency' => 'La fiecare livrare', 'measurement_tool' => '', 'visual_control' => 'da', 'performed_by' => 'Director de producţie', 'registered_in' => 'Aviz', 'category_id' => '8']);
    }
}
