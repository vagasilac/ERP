<?php

use App\Models\ProjectCalculationsSetting;
use Illuminate\Database\Seeder;

class ProjectCalculationsSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectCalculationsSetting::create(['name' => 'Debitare CNC - plasma', 'type' => 'operation', 'value' => 12, 'slug' => 'cutting[cnc-plasma]']);
        ProjectCalculationsSetting::create(['name' => 'Debitare CNC - oxigaz', 'type' => 'operation', 'value' => 12, 'slug' => 'cutting[cnc-oxigaz]']);
        ProjectCalculationsSetting::create(['name' => 'Găurire prin debitare (CNC - plasma)', 'type' => 'operation', 'value' => 15, 'slug' => 'cutting[cnc-plasma-drilling]']);
        ProjectCalculationsSetting::create(['name' => 'Găurire prin debitare (CNC - oxigaz)', 'type' => 'operation', 'value' => 15, 'slug' => 'cutting[cnc-oxigaz-drilling]']);
        ProjectCalculationsSetting::create(['name' => 'Debitare Profile', 'type' => 'operation', 'value' => 8, 'slug' => 'cutting[profiles]']);
        ProjectCalculationsSetting::create(['name' => 'Frezare CNC', 'type' => 'operation', 'value' => 25, 'slug' => 'processing[cnc-milling]']);
        ProjectCalculationsSetting::create(['name' => 'Strunjire', 'type' => 'operation', 'value' => 12, 'slug' => 'processing[turning]']);
        ProjectCalculationsSetting::create(['name' => 'Strunjire CNC', 'type' => 'operation', 'value' => 12, 'slug' => 'processing[turning-cnc]']);
        ProjectCalculationsSetting::create(['name' => 'Filetare', 'type' => 'operation', 'value' => 5, 'slug' => 'processing[threading]']);
        ProjectCalculationsSetting::create(['name' => 'Eroziune electrică', 'type' => 'operation', 'value' => 5, 'slug' => 'processing[electrical-discharge]']);
        ProjectCalculationsSetting::create(['name' => 'Îndoire', 'type' => 'operation', 'value' => 5, 'slug' => 'locksmith[bending]']);
        ProjectCalculationsSetting::create(['name' => 'Roluire', 'type' => 'operation', 'value' => 5, 'slug' => 'locksmith[rolling]']);
        ProjectCalculationsSetting::create(['name' => 'Șanfrenare', 'type' => 'operation', 'value' => 5, 'slug' => 'locksmith[chamfering]']);
        ProjectCalculationsSetting::create(['name' => 'Ajustare', 'type' => 'operation', 'value' => 5, 'slug' => 'locksmith[adjustment]']);
        ProjectCalculationsSetting::create(['name' => 'Asamblare', 'type' => 'operation', 'value' => 5, 'slug' => 'locksmith[assembly]']);
        ProjectCalculationsSetting::create(['name' => 'Sudare', 'type' => 'operation', 'value' => 5, 'slug' => 'welding[welding]']);
        ProjectCalculationsSetting::create(['name' => 'Înnădire', 'type' => 'operation', 'value' => 5, 'slug' => 'welding[extension]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - PT', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[pt]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - VT', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[vt]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - MT', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[mt]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - RT', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[rt]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - UT', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[ut]']);
        ProjectCalculationsSetting::create(['name' => 'Examinări NDT - Probă de presiune', 'type' => 'operation', 'value' => 5, 'slug' => 'ndt_testing[pressure-test]']);
        ProjectCalculationsSetting::create(['name' => 'Premontaj', 'type' => 'operation', 'value' => 5, 'slug' => 'preassembly[preassembly]']);
        ProjectCalculationsSetting::create(['name' => 'Sablare - Autosablare', 'type' => 'operation', 'value' => 28, 'slug' => 'sanding[auto]']);
        ProjectCalculationsSetting::create(['name' => 'Sablare - Cabină', 'type' => 'operation', 'value' => 28, 'slug' => 'sanding[cabin]']);
        ProjectCalculationsSetting::create(['name' => 'Zincare', 'type' => 'operation', 'value' => 5, 'slug' => 'electrogalvanization[zinc_coating]']);
        ProjectCalculationsSetting::create(['name' => 'Cromare', 'type' => 'operation', 'value' => 5, 'slug' => 'electrogalvanization[chroming]']);
        ProjectCalculationsSetting::create(['name' => 'Vopsire', 'type' => 'operation', 'value' => 5, 'slug' => 'electrogalvanization[painting]']);
        ProjectCalculationsSetting::create(['name' => 'Montaj', 'type' => 'assembly-operation', 'value' => 5, 'slug' => 'assembly']);
        ProjectCalculationsSetting::create(['name' => 'Deplasare', 'type' => 'travel', 'value' => 0.5, 'slug' => 'travel']);
        ProjectCalculationsSetting::create(['name' => 'Diurna', 'type' => 'travel', 'value' => 6.74, 'slug' => 'daily_allowance']);
        ProjectCalculationsSetting::create(['name' => 'Cazare', 'type' => 'travel', 'value' => 7.87, 'slug' => 'accommodation']);
        ProjectCalculationsSetting::create(['name' => 'Coeficient cheltuieli indirecte', 'type' => 'price', 'value' => 0.1, 'slug' => 'overheads']);
        ProjectCalculationsSetting::create(['name' => 'Coeficient profit', 'type' => 'price', 'value' => 0.1, 'slug' => 'profit']);
        ProjectCalculationsSetting::create(['name' => 'Salariu pe oră', 'type' => 'price', 'value' => 5, 'slug' => 'salary_per_hour']);
    }
}
