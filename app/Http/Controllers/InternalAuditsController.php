<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Models\Process;
use App\Models\InternalAudit;
use App\Models\InternalAuditProcess;

use App\Http\Requests;
use Carbon\Carbon;

class InternalAuditsController extends Controller
{
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

    public function index()
    {
        if (!hasPermission('Internal audit list')) {
            abort(401);
        }

        $internal_audits = InternalAudit::all();

        return view('internal_audits.index')->with('internal_audits', $internal_audits);
    }

    /**
     * Show the form for creating a new Internal audit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Internal audit add')) {
            abort(401);
        }

        return view('internal_audits.create');
    }

    /**
     * Store a newly created Internal audit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->all();

        $year = Carbon::createFromFormat('d-m-Y', $req['date_scheduled'])->year;
        $count = InternalAudit::where('date_scheduled', 'LIKE', '%' . $year . '%')->get()->count();
        $req['audit'] = $year . '-' . ($count + 1);

        $req['date_conducted'] = null;
        $req['date_scheduled'] = Carbon::createFromFormat('d-m-Y', $req['date_scheduled'])->toDateString();

        $item = InternalAudit::create($req);

        $processes = explode(',', $req['process_id']);

        foreach ($processes as $process) {
            InternalAuditProcess::create(['internal_audit_id' => $item->id, 'process_id' => $process]);
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat internal audit cu nr. :internal_audits', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'internal_audits' =>  $item->id]), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('InternalAuditsController@index');
    }

    public function get_processes(Request $request)
    {
        $term = Input::get('q');

        $internal_audits_object = Process::where('name', 'LIKE', '%' . $term . '%')->orderBy('name')->get()->toArray();
        $internal_audits_object = collect($internal_audits_object);
        $internal_audits_object = $internal_audits_object->values()->all();

        return $internal_audits_object;
    }
}
