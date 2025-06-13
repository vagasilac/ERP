<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\CotoOpportunityRegister;
use App\Models\CotoIssue;
use App\Models\CotoOpportunityRegisterDocuments;
use App\Models\Process;

use App\Http\Requests;

class CotoOpportunityRegistersController extends Controller
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
   * Display a listing of the COTO Opportunity Register.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (!hasPermission('Coto opportunity register list')) {
            abort(401);
        }

        $coto_obj = CotoIssue::query();
        $coto_obj = $coto_obj->leftJoin('processes', 'coto_issues.processes_id', '=', 'processes.id')
            ->join('coto_parties', 'coto_issues.coto_parties_id', '=', 'coto_parties.id')
            ->join('coto_opportunity_registers', 'coto_issues.id', '=', 'coto_issue_id')
            ->select(
                'coto_opportunity_registers.likelihood', 'coto_opportunity_registers.occurrences',
                'coto_opportunity_registers.prob_rating', 'coto_opportunity_registers.potential_for_new_business',
                'coto_opportunity_registers.potential_expansion_of_current_business', 'coto_opportunity_registers.potential_improvement_in_satisfying_regulations',
                'coto_opportunity_registers.potential_improvement_to_internal_qms_processes', 'coto_opportunity_registers.improvement_to_company_reputation',
                'coto_opportunity_registers.potential_cost_of_implementation', 'coto_opportunity_registers.ben_rating', 'coto_opportunity_registers.opp_factor',
                'coto_opportunity_registers.opportunity_pursuit_plan', 'coto_opportunity_registers.post_implementation_success', 'coto_opportunity_registers.status',
                'processes.name',
                'coto_issues.coto_parties_id', 'coto_issues.issues_concern', 'coto_issues.id',
                'coto_parties.interested_party'
            );

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $coto_obj = $coto_obj->where('name', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'opportunity');
            $coto_obj = $coto_obj->orWhere('issues_concern', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'opportunity');
            $coto_obj = $coto_obj->orWhere('interested_party', 'LIKE', '%' . $request->input('search') . '%')->where('bias', 'opportunity');
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
            foreach ($item->coto_opportunity_register as $coto_opportunity_register) {
                if (count($coto_opportunity_register->documents) > 0) {
                    $item['document'] = true;
                }
                else {
                    $item['document'] = false;
                }
            }
            $item->opportunity = $item->coto_party->interested_party . ' - ' . $item->issues_concern;
        }


        if ($request->ajax()) {
            $view = view('coto_opportunity_registers._or_list');
        }
        else {
            $view = view('coto_opportunity_registers.index');
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
     * Show the form for editing the specified COTO Opportunity Register.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Coto opportunity register edit')) {
            abort(401);
        }

        $item = CotoIssue::findOrFail($id);

        $registers = CotoOpportunityRegister::where('coto_issue_id', $id);

        if ($registers->first() == null) {
            $registers->likelihood = 1;
            $registers->occurrences = 1;
            $registers->potential_for_new_business = 1;
            $registers->potential_expansion_of_current_business = 1;
            $registers->potential_improvement_in_satisfying_regulations = 1;
            $registers->potential_improvement_to_internal_qms_processes = 1;
            $registers->improvement_to_company_reputation = 1;
            $registers->potential_cost_of_implementation = 1;
            $registers->post_implementation_success = 1;
            $registers->opportunity_pursuit_plan = '';
            $registers->status = 'open';
            $registers->id = '';
        }
        else {
            $registers = $registers->first();
        }


        $item->opportunity = $item->coto_party->interested_party . ' - ' . $item->issues_concern;
        $item->processes = $item->process->name;
        $documents = CotoOpportunityRegisterDocuments::where('coto_opp_reg_id', $registers->id)->get();


        return view('coto_opportunity_registers.edit')->with(['item' => $item, 'registers' => $registers, 'documents' => $documents]);
    }

    /**
     * Update the specified COTO Opportunity Register in storage.
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

        unset($req['opportunity']);
        unset($req['processes']);
        unset($req['_token']);

        $register = CotoOpportunityRegister::where('coto_issue_id', $id);

        if ($register->first() == null) {
            CotoOpportunityRegister::create($req);
        }
        else {
            $register->update($req);
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        $item = CotoIssue::findOrFail($id);
        $name = $item->coto_party->interested_party . ' - ' . $item->issues_concern;

        // log
        loggr(trans('log.:user a editat contextul organizației registrul de oportunități :coto_opportunity_registers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_opportunity_registers' => '<a href="' . action('CotoOpportunityRegistersController@edit', $id) . '" target="_blank">' . $name . '</a>']), Auth::id(), '{"entity_type": "' . CotoOpportunityRegister::class . '", "entity_id": ' . $id . '}');

        return redirect()->action('CotoOpportunityRegistersController@edit', $id);
    }

    /**
     * Upload documents files for a project
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = CotoOpportunityRegister::where('coto_issue_id', $id);
        $input = Input::all();

        if ($item->first() == null) {
            $new_item['coto_issue_id'] = $id;
            $new_item['process_id'] = Process::where('name', $input['processes'])->first()->id;
            CotoOpportunityRegister::create($new_item);
        }

        $item = CotoOpportunityRegister::where('coto_issue_id', $id)->first();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/coto_opportunity_registers/' . $id . '/documents')) {
                Storage::makeDirectory('ims/coto_opportunity_registers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('ims/coto_opportunity_registers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('ims/coto_opportunity_registers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'ims/coto_opportunity_registers/' . $id . '/documents/' . $filename]);

            CotoOpportunityRegisterDocuments::create([
                'coto_opp_reg_id' => $item->id,
                'name' => $filename,
                'file_id' => $new_file->id
            ]);

            //log
            loggr(trans('log.:user a încărcat documentul :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => '<a href="' . action('FilesController@show', ['id' => $new_file->id, 'name' => $filename]) . '" target="_blank">' . $filename . '</a>']), Auth::id(), '{"entity_type": "' . CotoOpportunityRegister::class . '", "entity_id": ' . $new_file->id . '}');

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
                $document = CotoOpportunityRegisterDocuments::findOrFail($document_id);
                $file = \App\Models\File::findOrfail($document->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $name = explode('/', $file->file);
                $filenames .= array_pop($name) . ', ';

                $document->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $filenames = preg_replace('/,\s$/', '', $filenames);

            //log
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . CotoOpportunityRegister::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CotoOpportunityRegistersController@edit', $id);

    }
}
