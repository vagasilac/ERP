<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deadline'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =  ['name', 'description', 'customer_id', 'primary_responsible', 'secondary_responsible', 'deadline', 'management_note', 'primary_code', 'secondary_code', 'production_code', 'quantity', 'production_no', 'offer_request', 'status', 'type', 'parent_id', 'version'];


    /**
     * Get the production name of the project
     *
     * @return string
     */
    public function production_name()
    {
        return $this->production_no . $this->production_code;
    }

    /**
     * Get the datasheet for the project.
     */
    public function datasheet()
    {
        return $this->hasOne('App\Models\ProjectDatasheet');
    }

    /**
     * Has the project cutting operation?
     */
    public function has_cutting()
    {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'cutting') && !is_null($datasheet->cutting) && count($datasheet->cutting) > 0) {
                foreach ($datasheet->cutting as $key => $value) {
                    if (is_numeric($value) && $value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project processing operation?
     */
    public function has_processing() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'processing') && !is_null($datasheet->processing) && count($datasheet->processing) > 0) {
                foreach ($datasheet->processing as $key => $value) {
                    if (is_numeric($value) && $value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project ndt testing operation?
     */
    public function has_ndt_testing() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'ndt_testing') && !is_null($datasheet->ndt_testing) && count($datasheet->ndt_testing) > 0) {
                foreach ($datasheet->ndt_testing as $key => $value) {
                    if (is_numeric($value) && $value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project locksmithing operation?
     */
    public function has_locksmithing() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'locksmith') && !is_null($datasheet->locksmith) && count($datasheet->locksmith) > 0) {
                foreach ($datasheet->locksmith as $key => $value) {
                    if (is_numeric($value) && $value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project sanding operation?
     */
    public function has_sanding() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'sanding') && !is_null($datasheet->sanding) && count($datasheet->sanding) > 0) {
                foreach ($datasheet->sanding as $key => $value) {
                    if ($value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project welding operation?
     */
    public function has_welding() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;

            if (property_exists($datasheet, 'welding') && !is_null($datasheet->welding) && count($datasheet->welding) > 0) {
                foreach ($datasheet->welding as $key => $value) {
                    if (is_numeric($value) && $value == 1) return true;
                }
            }
        }
        return false;
    }

    /**
     * Has the project painting operation?
     */
    public function has_painting() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;
            if (property_exists($datasheet, 'electrogalvanization') && !is_null($datasheet->electrogalvanization) && property_exists($datasheet->electrogalvanization, 'painting') && !is_null($datasheet->electrogalvanization->painting) && count($datasheet->painting) > 0) {
                 return true;
            }
        }
        return false;
    }

    /**
    * Has the project assembling operation?
    */
    public function has_assembling() {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = $datasheet->data;
            if (property_exists($datasheet, 'assembly') && !is_null($datasheet->assembly) && count($datasheet->assembly) > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if a variable is set in datasheet
     *
     * @param $var
     * @return bool
     */
    public function is_set($var) {
        $datasheet = self::datasheet()->first();
        if ($datasheet != null) {
            $datasheet = json_decode(json_encode($datasheet->data), true);

            $keys = explode('[', $var);
            $var_temp = $datasheet;
            foreach ($keys as $key) {
                $k = str_replace(']', '', $key);
                if (isset($var_temp[$k])) {
                    $var_temp = $var_temp[$k];
                }
                else return false;
            }
        }
        return true;
    }

    /**
     * Return value of the specified variable
     *
     * @param $var
     * @return bool|mixed
     */
    public function get_datasheet_variable_value($var) {
        $datasheet = self::datasheet()->first();
        $var_temp = '';
        if ($datasheet != null) {
            $datasheet = json_decode(json_encode($datasheet->data), true);

            $keys = explode('[', $var);
            $var_temp = $datasheet;
            foreach ($keys as $key) {
                $k = str_replace(']', '', $key);


                if (isset($var_temp[$k])) {
                    $var_temp = $var_temp[$k];
                }
                else {
                    return false;
                }
            }
        }
        return $var_temp;
    }

    /**
     * Get the calculation for the project.
     */
    public function calculation()
    {
        return $this->hasOne('App\Models\ProjectCalculation');
    }

    /**
     * Get the customer for the project.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * Get the primary responsible for the project.
     */
    public function	primary_responsible_user()
    {
        return $this->belongsTo('App\Models\User', 'primary_responsible');
    }

    /**
     * Get the secondary responsible for the project.
     */
    public function	secondary_responsible_user()
    {
        return $this->belongsTo('App\Models\User', 'secondary_responsible');
    }

    /**
    * Get the parent of the project.
    */
    public function	parent()
    {
        return $this->belongsTo('App\Models\Project', 'parent_id');
    }

    /**
     * Get the children of the project.
     */
    public function	children()
    {
        return $this->hasMany('App\Models\Project', 'parent_id');
    }

    /**
     * Get the drawings for the project.
     */
    public function drawings()
    {
        return $this->hasMany('App\Models\ProjectDrawing')->orderBy('name');
    }

    /**
     * Get the quality control drawings for the project.
     */
    public function quality_control_drawings()
    {
        return $this->hasMany('App\Models\ProjectQualityControlDrawing');
    }

    /**
     * Get the contracts for the project.
     */
    public function contracts()
    {
        return $this->hasMany('App\Models\ProjectContract')->orderBy('name');
    }

    /**
     * Get the offers for the project.
     */
    public function output_offers()
    {
        return $this->hasMany('App\Models\ProjectOutputOffer')->orderBy('name');
    }

    /**
     * Get the mails for the project.
     */
    public function mails()
    {
        return $this->hasMany('App\Models\ProjectMail')->orderBy('name');
    }

    /**
     * Get the photos for the project.
     */
    public function photos()
    {
        return $this->hasMany('App\Models\ProjectPhoto')->orderBy('name');
    }

    /**
     * Get the documents for the project.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\ProjectDocument')->orderBy('name');
    }

    /**
     * Get the cutting files for the project.
     */
    public function cuttings()
    {
        return $this->hasMany('App\Models\ProjectCutting')->orderBy('name');
    }

    /**
     * Get the invoices for the project.
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\ProjectInvoice')->orderBy('name');
    }

    /**
     * Get the rfq for the project.
     */
    public function rfq()
    {
        return $this->hasMany('App\Models\ProjectRFQ')->orderBy('name');
    }

    /*
    * Get the order confirmations for the project.
     */
    public function order_confirmations()
    {
        return $this->hasMany('App\Models\ProjectOrderConfirmation')->orderBy('name');
    }


    /**
     * Get the subassemblies for the project.
     */
    public function subassemblies()
    {
        return $this->hasMany('App\Models\ProjectSubassembly')->orderBy('name');
    }

    /**
     * Get the subassembly groups for the project.
     */
    public function subassembly_groups()
    {
        return $this->hasMany('App\Models\ProjectSubassemblyGroup')->orderBy('name');
    }

    /**
     * Get the subassembly parts for the project.
     */
    public function subassembly_parts()
    {
        return $this->hasMany('App\Models\ProjectSubassemblyPart')->orderBy('name');
    }

    /**
     * Get the control plan for the project.
     */
    public function control_plan()
    {
        return $this->hasMany('App\Models\ProjectControlPlan');
    }

    /**
     * Get the drawings register for the project.
     */
    public function drawings_register()
    {
        return $this->hasMany('App\Models\ProjectDrawingsRegister');
    }

    /**
     * Get the gantt tasks for the project.
     */
    public function gantt_tasks()
    {
        return $this->hasMany('App\Models\GanttTask');
    }

    /**
     * Get the transport files for the project.
     */
    public function transport_files()
    {
        return $this->hasMany('App\Models\ProjectTransport')->orderBy('name');
    }

    /**
     * Get the materials for the project.
     */
    public function project_materials()
    {
        return $this->hasMany('App\Models\ProjectMaterial');
    }

    /**
     * Get the materials offers for the project.
     */
    public function materials_offer()
    {
        return $this->hasMany('App\Models\ProjectOffer');
    }

    /**
     * Get the time tracking
     */
    public function time_tracking()
    {
        return $this->hasMany('App\Models\ProjectTimeTracking');
    }

    /**
     * Get requirements analysis
     */
    public function requirements_analysis()
    {
        return $this->hasMany('App\Models\ProjectRequirementsAnalysis')->orderBy('date', 'DESC');
    }

    /**
     * Get the progress of the project in offer stage
     */
    public function get_offer_progress()
    {
        // 1 = new
        $progress = 1;

        // 2 = has subassemblies
        if (count($this->subassemblies) > 0) {
            $progress = 2;
        }
        else {
            return $progress;
        }

        // 3 = all materials have gross size
        if (!is_null($this->calculation) && !is_null($this->calculation->data) && !is_null($this->calculation->data->materials)) {

            // profiles
            if (isset($this->calculation->data->materials->profile) && count($this->calculation->data->materials->profile) > 0) {
                foreach ($this->calculation->data->materials->profile as $profile) {
                    if (!isset($profile->gross_sizes)) {
                        return $progress;
                    }
                    else {
                        foreach ($profile->gross_sizes as $size) {
                            if ($size->length == '') {
                                return $progress;
                            }
                        }
                    }
                }
            }

            // plates
            if (isset($this->calculation->data->materials->plate) && count($this->calculation->data->materials->plate) > 0) {
                foreach ($this->calculation->data->materials->plate as $plate) {
                    if (!isset($plate->gross_sizes)) {
                        return $progress;
                    }
                    else {
                        foreach ($plate->gross_sizes as $size) {
                            if ($size->length == '' || $size->width == '') {
                                return $progress;
                            }
                        }
                    }
                }
            }

            // other materials
            if (isset($this->calculation->data->materials->other) && count($this->calculation->data->materials->other) > 0) {
                foreach ($this->calculation->data->materials->other as $material) {
                    if (!isset($material->quantity)) {
                        return $progress;
                    }
                    else {
                        if ($material->quantity == '' || $material->quantity == 0) {
                            return $progress;
                        }
                    }
                }
            }

            $progress = 3;
        }
        else {
            return $progress;
        }

        // 4 = all materials has offer request
        if (!is_null($this->calculation) && !is_null($this->calculation->data->materials) && count($this->project_materials) > 0) {
            foreach ($this->project_materials as $project_material) {
                if (is_null($project_material->offer)) {
                    return $progress;
                }
            }

            $progress = 4;
        }
        else {
            return $progress;
        }

        // 5 = has total price
        if (!is_null($this->calculation) && ($this->calcualation->data->total > 0)) {
           $progress = 5;
        }
        else {
            return $progress;
        }

        // 6 = approved by management
        if (count($this->folders) > 0) {
            $has_offer_status = false;
            foreach ($this->folders as $folder) {
                if ($folder->folder->name == 'Oferta') {
                    $has_offer_status = true;
                    if ($folder->folder->status($this->id) != 'approved') {
                        return $progress;
                    }
                    $progress = 6;
                }
            }
            if (!$has_offer_status) {
                return $progress;
            }
        }
        else {
            return $progress;
        }

        // @TODO 7 = offer sent
        // $progress = 7;

        return $progress;
    }

    /**
     * Get the progress percentege of the project
     */
    public function progress_percentage()
    {
        $subassemblies_percentage_sum = 0;
        if (count($this->subassemblies) > 0) {
            foreach ($this->subassemblies as $subassembly) {
                $subassemblies_percentage_sum = $subassemblies_percentage_sum + $subassembly->progress_percentage();
            }
            $percentege = round($subassemblies_percentage_sum / count($this->subassemblies), 2);
        }
        else {
            $completed_process = $this->time_tracking()->where('type', 'stop')->get();
            if (count($completed_process) > 0) $percentege = 100;
            else {
                $in_progress_process = $this->time_tracking()->where('type', 'pause')->orderBy('created_at')->first();
                if (count($in_progress_process) > 0) {
                    $percentege = intval($in_progress_process->in_process_item_percentage);

                }
                else $percentege = 0;
            }

        }

        return $percentege;
    }

    /**
     * Get project folders
     */
    public function folders()
    {
        return $this->hasMany('App\Models\ProjectFolderStatus');
    }

    /**
     * Verify if the project has rejected folder
     *
     * @return bool
     */
    public function has_rejected_folder()
    {
        $folder_status = ProjectFolderStatus::where('project_id', $this->id)->where('status', 'rejected')->first();

        return !is_null($folder_status) > 0 ? true : false;
    }

}
