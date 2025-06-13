<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Models\CotoIssue;
use App\Models\CotoParty;
use App\Models\Process;

class CotoIssuesController extends Controller
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
    * Display a listing of the COTO Issues.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if (!hasPermission('Coto issues list')) {
            abort(401);
        }

        $coto_obj = CotoIssue::query();

        $coto_obj = $coto_obj->join('coto_parties', 'coto_issues.coto_parties_id', '=', 'coto_parties.id')
                             ->leftJoin('processes', 'coto_issues.processes_id', '=', 'processes.id')
                             ->select('coto_issues.*', 'coto_parties.interested_party', 'processes.name');

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $coto_obj = $coto_obj->where('interested_party', 'LIKE', '%' . $request->input('search') . '%');
            $coto_obj = $coto_obj->orWhere('issues_concern', 'LIKE', '%' . $request->input('search') . '%');
            $coto_obj = $coto_obj->orWhere('name', 'LIKE', '%' . $request->input('search') . '%');
            $coto_obj = $coto_obj->orWhere('record_reference', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'user') {
                $coto_obj = $coto_obj->join('users', 'coto_issues.user_id', '=', 'users.id');
                $coto_obj = $coto_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else if ($request->input('sort') == 'bias') {
                $coto_obj = $coto_obj->orderByRaw(
                    "CASE bias
                     WHEN 'mixed' THEN 1
                     WHEN 'neutral' THEN 2
                     WHEN 'opportunity' THEN 3
                     WHEN 'risk' THEN 4
                     END " . $request->input('sort_direction')
                );
            }
            else if ($request->input('sort') == 'priority') {
                $coto_obj = $coto_obj->orderByRaw(
                    "CASE priority
                     WHEN 'high' THEN 1
                     WHEN 'medium' THEN 2
                     WHEN 'low' THEN 3
                     WHEN 'emergency' THEN 4
                     END " . $request->input('sort_direction')
                );
            }
            else if ($request->input('sort') == 'treatment_method') {
                $coto_obj = $coto_obj->orderByRaw(
                    "CASE treatment_method
                     WHEN 'accept_risk' THEN 1
                     WHEN 'management_review_activity' THEN 2
                     WHEN 'other' THEN 3
                     WHEN 'other_auditing' THEN 4
                     WHEN 'root_cause_analysis' THEN 5
                     WHEN 'vendor_auditing' THEN 6
                     WHEN 'marketing_enhancement' THEN 7
                     WHEN 'risk_register' THEN 8
                     WHEN 'corrective_action_request' THEN 9
                     END " . $request->input('sort_direction')
                );
            }
            else {
                $coto_obj = $coto_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }
        }
        else {
            $coto_obj = $coto_obj->orderBy('interested_party');
        }

        $items = $coto_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('coto_issues._ci_list');
        }
        else {
            $view = view('coto_issues.index');
        }

        $view = $view->with('items', $items)->with('colors', Config::get('color.user_colors'));

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new COTO Issues.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Coto issues add')) {
            abort(401);
        }

        return view('coto_issues.create');
    }

    /**
     * Store a newly created COTO Issues in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'interested_party' => 'required|exists:coto_parties,interested_party',
            'issues_concern' => 'required',
            'processes' => 'required|exists:processes,name',
            'record_reference' => 'required'
        ]);

        $req = $request->all();

        $req['coto_parties_id'] = CotoParty::where('interested_party', $req['interested_party'])->first()->id;
        $req['processes_id'] = Process::where('name', $req['processes'])->first()->id;

        $item = CotoIssue::create($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        $name = $item->coto_party->interested_party . ' - ' . $item->issues_concern;

        // log
        loggr(trans('log.:user a adăugat contextul organizației probleme :coto_issues', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_issues' => '<a href="' . action('CotoIssuesController@edit', $item->id) . '" target="_blank">' . $name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CotoIssuesController@edit', $item->id);
    }

    /**
     * Show the form for editing the specified COTO Issues.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Coto issues edit')) {
            abort(401);
        }

        $item = CotoIssue::findOrFail($id);

        $item->interested_party = $item->coto_party->interested_party;
        $item->processes = $item->process->name;


        return view('coto_issues.edit')->with(['item' => $item]);
    }

    /**
     * Update the specified COTO Issues in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'interested_party' => 'required|exists:coto_parties,interested_party',
            'issues_concern' => 'required',
            'processes' => 'required|exists:processes,name',
            'record_reference' => 'required'
        ]);

        $item = CotoIssue::findOrFail($id);

        $req = $request->all();

        if ($req['user_id'] == '')
        {
            $req['user_id'] = $item->user_id;
        }

        $req['coto_parties_id'] = CotoParty::where('interested_party', $req['interested_party'])->first()->id;
        $req['processes_id'] = Process::where('name', $req['processes'])->first()->id;

        $item->update($req);


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        $name = $item->coto_party->interested_party . ' - ' . $item->issues_concern;

        // log
        loggr(trans('log.:user a editat contextul organizației probleme :coto_issues', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_issues' => '<a href="' . action('CotoIssuesController@edit', $item->id) . '" target="_blank">' . $name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CotoIssuesController@edit', $id);
    }

    /**
     * Multiple remove of COTO Issues from storage.
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
                $item = CotoIssue::findOrFail($id);

                $names .= $item->coto_party->interested_party . ' - ' . $item->issues_concern . ', ';

                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters contextul organizației probleme :coto_issues', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_issues' => $names]), Auth::id(), '{"entity_type": "' . CotoIssue::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CotoIssuesController@index');

    }
}
