<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\CotoRiskRegister;
use App\Models\Process;
use App\Models\CotoIssue;
use App\Models\CotoRiskRegistersDocument;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class CotoRiskRegistersController extends Controller
{
    private $items_per_page;

    function __construct()
    {
        $this->middleware('auth');
        $this->set_variables();
    }

    /**
     * Assigning default values to class variables
     */
    private function set_variables()
    {
        $this->items_per_page = Config::get('settings.items_per_page');
    }

    /*
    * Display a listing of the COTO Risks Register.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if (!hasPermission('Coto risks register list')) {
            abort(401);
        }

        $coto_obj = CotoIssue::query();
        $coto_obj = $coto_obj->leftJoin('processes', 'coto_issues.processes_id', '=', 'processes.id')
                             ->join('coto_parties', 'coto_issues.coto_parties_id', '=', 'coto_parties.id')
                             ->join('coto_risk_registers', 'coto_issues.id', '=', 'coto_issue_id')
                             ->select(
                                 'coto_risk_registers.risk_likelihood', 'coto_risk_registers.risk_occurrences', 'coto_risk_registers.risk_potential_loss_of_contracts',
                                 'coto_risk_registers.risk_potential_risk_to_human_health',
                                 'coto_risk_registers.risk_inability_to_meet_contract_terms', 'coto_risk_registers.risk_potential_violation_of_regulations',
                                 'coto_risk_registers.risk_impact_on_company_reputation', 'coto_risk_registers.risk_est_cost_of_correction', 'coto_risk_registers.mitigation_plan',
                                 'coto_risk_registers.mitigation_likelihood', 'coto_risk_registers.mitigation_occurrences', 'coto_risk_registers.mitigation_potential_loss_of_contracts',
                                 'coto_risk_registers.mitigation_potential_risk_to_human_health',
                                 'coto_risk_registers.mitigation_inability_to_meet_contract_terms', 'coto_risk_registers.mitigation_potential_violation_of_regulations',
                                 'coto_risk_registers.mitigation_impact_on_company_reputation', 'coto_risk_registers.mitigation_est_cost_of_correction', 'coto_risk_registers.mitigation_plan',
                                 'coto_risk_registers.risk_prob_rating', 'coto_risk_registers.risk_cons_rating', 'coto_risk_registers.before_risk_factor',
                                 'coto_risk_registers.mitigation_prob_rating', 'coto_risk_registers.mitigation_cons_rating', 'coto_risk_registers.after_risk_factor',
                                 'processes.name',
                                 'coto_issues.coto_parties_id', 'coto_issues.issues_concern', 'coto_issues.id',
                                 'coto_parties.interested_party'
                             );

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $coto_obj = $coto_obj->where('name', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'risk');
            $coto_obj = $coto_obj->orWhere('issues_concern', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'risk');
            $coto_obj = $coto_obj->orWhere('interested_party', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'risk');
        }

        //Sort
        if ($request->has('sort')) {
            $coto_obj = $coto_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }
        else {
           $coto_obj = $coto_obj->orderBy('name');
        }

        $items = $coto_obj->paginate($this->items_per_page);

        foreach ($items as $item) {
            foreach ($item->coto_risk_register as $coto_risk_register) {
                if (count($coto_risk_register->documents) > 0) {
                    $item['document'] = true;
                }
                else {
                    $item['document'] = false;
                }
            }

            $item->risk = $item->coto_party->interested_party . ' - ' . $item->issues_concern;

        }


        if ($request->ajax()) {
            $view = view('coto_risk_registers._cr_list');
        }
        else {
            $view = view('coto_risk_registers.index');
        }

        $view = $view->with('items', $items);


        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }


    /**
     * Show the form for editing the specified COTO Risks Register.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Coto risks register edit')) {
            abort(401);
        }

        $item = CotoIssue::findOrFail($id);

        $registers = CotoRiskRegister::where('coto_issue_id', $id);

        if ($registers->first() == null) {
            $registers->risk_likelihood = 1;
            $registers->risk_occurrences = 1;
            $registers->risk_potential_loss_of_contracts = 1;
            $registers->risk_potential_risk_to_human_health = 1;
            $registers->risk_inability_to_meet_contract_terms = 1;
            $registers->risk_potential_violation_of_regulations = 1;
            $registers->risk_impact_on_company_reputation = 1;
            $registers->risk_est_cost_of_correction = 1;

            $registers->mitigation_likelihood = 1;
            $registers->mitigation_occurrences = 1;
            $registers->mitigation_potential_loss_of_contracts = 1;
            $registers->mitigation_potential_risk_to_human_health = 1;
            $registers->mitigation_inability_to_meet_contract_terms = 1;
            $registers->mitigation_potential_violation_of_regulations = 1;
            $registers->mitigation_impact_on_company_reputation = 1;
            $registers->mitigation_est_cost_of_correction = 1;

            $registers->mitigation_plan = '';
            $registers->id = '';
        }
        else {
            $registers = $registers->first();
        }


        $item->risk = $item->coto_party->interested_party . ' - ' . $item->issues_concern;
        $item->processes = $item->process->name;
        $documents = CotoRiskRegistersDocument::where('coto_risk_register_id', $registers->id)->get();


        return view('coto_risk_registers.edit')->with(['item' => $item, 'registers' => $registers, 'documents' => $documents]);
    }

    /**
     * Update the specified COTO Risks Register in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = $request->all();

        $req['coto_issue_id'] = $id;
        $req['process_id'] = Process::where('name', $req['processes'])->first()->id;

        unset($req['risk']);
        unset($req['processes']);
        unset($req['_token']);

        $register = CotoRiskRegister::where('coto_issue_id', $id);

        if ($register->first() == null) {
            CotoRiskRegister::create($req);
        }
        else {
            $register->update($req);
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        $item = CotoIssue::findOrFail($id);
        $name = $item->coto_party->interested_party . ' - ' . $item->issues_concern;

        // log
        loggr(trans('log.:user a editat contextul organizației registrul riscurilor :coto_risk_registers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_risk_registers' => '<a href="' . action('CotoRiskRegistersController@edit', $item->id) . '" target="_blank">' . $name . '</a>']), Auth::id(), '{"entity_type": "' . CotoRiskRegister::class . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CotoRiskRegistersController@edit', $id);
    }


    /**
     * Upload documents files for a project
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = CotoRiskRegister::where('coto_issue_id', $id);
        $input = Input::all();

        if ($item->first() == null) {
            $new_item['coto_issue_id'] = $id;
            $new_item['process_id'] = Process::where('name', $input['processes'])->first()->id;
            CotoRiskRegister::create($new_item);
        }

        $item = CotoRiskRegister::where('coto_issue_id', $id)->first();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/coto_risk_registers/' . $id . '/documents')) {
                Storage::makeDirectory('ims/coto_risk_registers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('ims/coto_risk_registers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('ims/coto_risk_registers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'ims/coto_risk_registers/' . $id . '/documents/' . $filename]);

            CotoRiskRegistersDocument::create([
                'coto_risk_register_id' => $item->id,
                'name' => $filename,
                'file_id' => $new_file->id
            ]);

            //log
            loggr(trans('log.:user a încărcat documentul :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => '<a href="' . action('FilesController@show', ['id' => $new_file->id, 'name' => $filename]) . '" target="_blank">' . $filename . '</a>']), Auth::id(), '{"entity_type": "' . CotoRiskRegister::class . '", "entity_id": ' . $new_file->id . '}');

        }
        return 'true';
    }

    /**
     * Multiple destroy of documents from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function documents_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        $filenames = '';

        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $document_id) {
                $document = CotoRiskRegistersDocument::findOrFail($document_id);
                $file = \App\Models\File::findOrfail($document->file->id);

                $name = explode('/', $file->file);
                $filenames .= array_pop($name) . ', ';

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $document->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $filenames = preg_replace('/,\s$/', '', $filenames);

            //log
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . CotoRiskRegister::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CotoRiskRegistersController@edit', $id);

    }
}
