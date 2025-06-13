<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Capa;
use App\Models\CapaAssignment;
use App\Models\Process;
use App\Models\CapaPlan;
use App\Models\CapaResult;

use App\Http\Requests;
use Carbon\Carbon;

class CapasController extends Controller
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
    * Display a listing of the CAPAS.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if (!hasPermission('Capa list')) {
            abort(401);
        }

        $capa_obj = Capa::query();
        $capa_obj = $capa_obj->leftJoin('capa_results', 'capas.id', '=', 'capa_results.capa_id')
            ->leftJoin('capa_assignments', 'capas.id', '=', 'capa_assignments.capa_id')
            ->select('capas.id', 'capas.type', 'capas.source', 'capas.other_source', 'capas.process_id', 'capas.other_process', 'capas.priority', 'capas.description', 'capas.user_id', 'capas.created_at as date_submitted',
            'capa_results.created_at as action_complete_date',
            'capa_assignments.respond', 'capa_assignments.created_at as date_assigned');

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $capa_obj = $capa_obj->Where('description', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->has('type') && $request->input('type') != '0' && $request->input('type') != '') {
            $capa_obj = $capa_obj->where('capas.type', $request->input('type'));
        }

        if ($request->has('source') && $request->input('source') != '0' && $request->input('source') != '') {
            $capa_obj = $capa_obj->where('capas.source', $request->input('source'));
        }

        if ($request->has('process') && $request->input('process') != '0' && $request->input('process') != '') {
            $capa_obj = $capa_obj->where('capas.process_id', $request->input('process'));
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'id') {
                $capa_obj = $capa_obj->orderBy('capas.id', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'date_submitted') {
                $capa_obj = $capa_obj->orderBy('capas.created_at', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'type') {
                $capa_obj = $capa_obj->orderByRaw(
                    "CASE type
                    WHEN 'corrective_action' THEN 1
                    WHEN 'preventive_action' THEN 2
                    WHEN 'opportunity_for_improvement' THEN 3
                    END " . $request->input('sort_direction')
                );
            }
            else if ($request->input('sort') == 'source') {
                $capa_obj = $capa_obj->orderByRaw(
                    "CASE source
                    WHEN 'other' THEN 1
                    WHEN 'management_review_action_item' THEN 2
                    WHEN 'external_audit_finding' THEN 3
                    WHEN 'internal_audit_finding' THEN 4
                    WHEN 'employee_feedback' THEN 5
                    WHEN 'customer_feedback' THEN 6
                    WHEN 'supplier_feedback' THEN 7
                    END " . $request->input('sort_direction')
                );
            }
            else if ($request->input('sort') == 'process') {
                $capa_obj = $capa_obj->join('processes', 'capas.process_id', '=', 'processes.id');
                $capa_obj = $capa_obj->orderBy('processes.name', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'name_of_person_submitting') {
                $capa_obj = $capa_obj->join('users', 'capas.user_id', '=', 'users.id');
                $capa_obj = $capa_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'assigned_to') {
                $capa_obj = $capa_obj->join('users', 'capa_assignments.user_id', '=', 'users.id');
                $capa_obj = $capa_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else if($request->input('sort') == 'date_assigned') {
                $capa_obj = $capa_obj->orderBy('capa_assignments.created_at', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'action_complete_date') {
                $capa_obj = $capa_obj->orderBy('capa_results.created_at', $request->input('sort_direction'));
            }
            else {
                $capa_obj = $capa_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }
        }



        $items = $capa_obj->paginate($this->items_per_page);


        if ($request->ajax()) {
            $view = view('capa._capa_list');
        }
        else {
            $view = view('capa.index');
        }

        $view = $view->with(['items' => $items, 'colors' => Config::get('color.user_colors')]);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new CAPAS.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Capa add')) {
            abort(401);
        }

        $processes['-1'] = 'alte';

        foreach (Process::all() as $process) {
            $processes[$process->id] = $process->name;
        }

        return view('capa.create')->with('processes', $processes);
    }

    /**
     * Store a newly created CAPAS in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $req = $request->all();
        $req['user_id'] = Auth::id();

        if ($req['supplier_id'] == '') {
            $req['supplier_id'] = null;
        }

        if ($req['process_id'] == -1) {
            unset($req['process_id']);
        }

        $item = Capa::create($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat acțiune preventivă și corectivă cu nr. :capa', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'capa' => '<a href="' . action('CapasController@edit', $item->id) . '" target="_blank">' . $item->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CapasController@edit', $item->id);
    }

    /**
     * Show the form for editing the specified CAPAS.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Capa edit')) {
            abort(401);
        }

        $general = Capa::findOrFail($id);
        $assignment = CapaAssignment::where('capa_id', $id);
        $plan = CapaPlan::where('capa_id', $id);
        $result = CapaResult::where('capa_id', $id);

        $processes['-1'] = 'alte';

        foreach (Process::all() as $process) {
            $processes[$process->id] = $process->name;
        }

        if ($general->supplier_id != null) {
            $completed_tabs = [
                'assignment' => true,
                'plan' => true
            ];
        }
        else {
            $completed_tabs = [
                'assignment' => false,
                'plan' => false
            ];
        }


        if ($assignment->first() == null) {
            $assignment->respond = '';
            $assignment->user_id = null;
        }
        else {
            $assignment = $assignment->first();
            $completed_tabs['assignment'] = true;
        }

        if ($plan->first() == null) {
            $plan->root_cause_of_problem = '';
            $plan->action_plan = '';
        }
        else {
            $plan = $plan->first();
            $completed_tabs['plan'] = true;
        }

        if ($result->first() == null) {
            $result->result = '';
            $result->notes_and_justification = '';
        }
        else {
            $result = $result->first();
        }




        return view('capa.edit')->with(['general' => $general, 'assignment' => $assignment, 'plan' => $plan, 'result' => $result, 'completed_tabs' => $completed_tabs, 'processes' => $processes]);
    }

    /**
     * Update the specified CAPAS in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();

        if ($request->has('type')) {
            $this->validate($request, [
                'description' => 'required'
            ]);

            $capa = Capa::findOrFail($id);

            $general['type'] = $request->input('type');
            $general['source'] = $request->input('source');
            $general['other_source'] = $request->input('other_source');
            $general['process_id'] = $request->input('process_id');
            $general['other_process'] = $request->input('other_process');
            $general['priority'] = $request->input('priority');
            $general['description'] = $request->input('description');
            $general['user_id'] = $capa->user_id;

            if ($general['process_id'] == -1) {
                $general['process_id'] = null;
            }

            $capa->update($general);
        }

        if ($request->has('respond') && $request->input('user') != '') {

            $capa_assignment = CapaAssignment::where('capa_id', $id);

            $assignment['capa_id'] = $id;
            if ($request->input('user_id') == '') {
                $assignment['user_id'] = $capa_assignment->first()->user_id;
            }
            else {
                $assignment['user_id'] = $request->input('user_id');
            }

            $assignment['respond'] = Carbon::createFromFormat('d-m-Y', $request->input('respond'))->toDateTimeString();

            if ($capa_assignment->first() == null) {
                CapaAssignment::create($assignment);
            }
            else {
                $capa_assignment->update($assignment);
            }
        }

        if ($request->has('action_plan') && $request->input('root_cause_of_problem') != '' && $request->input('action_plan') != '') {

            $capa_plan = CapaPlan::where('capa_id', $id);

            $plan['capa_id'] = $id;
            $plan['root_cause_of_problem'] = $request->input('root_cause_of_problem');
            $plan['action_plan'] = $request->input('action_plan');

            if ($capa_plan->first() == null) {
                $plan['user_id'] = $user_id;
                CapaPlan::create($plan);
            }
            else {
                $plan['user_id'] = $capa_plan->first()->user_id;
                $capa_plan->update($plan);
            }
        }

        if ($request->has('result') && $request->input('result') != '' && $request->input('notes_and_justification') != '') {

            $capa_result = CapaResult::where('capa_id', $id);
            $result['capa_id'] = $id;
            $result['result'] = $request->input('result');
            $result['notes_and_justification'] = $request->input('notes_and_justification');

            if ($request->input('result') == 'fail') {
                $new_capa_obj = Capa::findOrFail($id)->toArray();
                $new_capa_obj['id'] = null;
                $new_capa_obj['created_at'] = Carbon::now();
                $new_capa_obj['updated_at'] = Carbon::now();

                Capa::create($new_capa_obj);
            }

            if ($capa_result->first() == null) {
                $result['user_id'] = $user_id;
                CapaResult::create($result);
            }
            else {
                $result['user_id'] = $capa_result->first()->user_id;
                $capa_result->update($result);
            }
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat acțiune preventivă și corectivă cu nr. :capa', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'capa' => '<a href="' . action('CapasController@edit', $capa->id) . '" target="_blank">' . $capa->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($capa) . '", "entity_id": ' . $capa->id . '}');

        return redirect()->action('CapasController@edit', $id);
    }

    /**
     * Multiple remove of CAPAS from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function multiple_destroy(Request $request)
    {
        $req = $request->all();
        $names = '';

        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $item = Capa::findOrFail($id);

                $names .= $id . ', ';

                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        $names = preg_replace('/,\s$/', '', $names);

        //log
        loggr(trans('log.:user a șters acțiunele preventivă și corectivă cu nr. :capa', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'capa' => $names]), Auth::id(), '{"entity_type": "' . Capa::class . '", "entity_id": ' . json_encode($req['remove']) . '}');

        return redirect()->action('CapasController@index');

    }
}
