<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Role;
use App\Models\Capa;
use App\Models\CotoIssue;
use App\Models\Process;
use App\Models\Supplier;
use App\Models\Education;
use App\Models\InternalAudit;
use App\Models\ManagementReviewMeeting;
use App\Models\ManagementReviewProcess;

use App\Http\Requests;

class ManagementReviewMeetingsController extends Controller
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
        $management_review_meetings = ManagementReviewMeeting::all();

        return view('management_review_meetings.index')->with('management_review_meetings', $management_review_meetings);
    }

    public function view($id)
    {
        $management_review_meeting = ManagementReviewMeeting::findOrFail($id);

        $internal_audits = InternalAudit::where('created_at', '>=', $management_review_meeting->created_at)->get();
        $coto_issues = CotoIssue::all();
        $capas = Capa::where('created_at', '>=', $management_review_meeting->created_at)->get();
        $education = Education::all();
        $suppliers = Supplier::all();
        $processes = $management_review_meeting->management_review_processes;

        return view('management_review_meetings.view')->with([
            'internal_audits' => $internal_audits,
            'coto_issues' => $coto_issues,
            'colors' => Config::get('color.user_colors'),
            'capas' => $capas,
            'education' => $education,
            'suppliers' => $suppliers,
            'processes' => $processes,
            'management_review_meeting' => $management_review_meeting
        ]);;
    }

    public function create()
    {
        $date = ManagementReviewMeeting::orderBy('created_at', 'desc')->first();

        if ($date == null) {
            $internal_audits = InternalAudit::all();
            $capas = Capa::all();
        }
        else {
            $internal_audits = InternalAudit::where('created_at', '>=', $date->created_at)->get();
            $capas = Capa::where('created_at', '>=', $date->created_at)->get();
        }

        $coto_issues = CotoIssue::all();
        $education = Education::all();
        $suppliers = Supplier::all();
        $processes = Process::all();

        return view('management_review_meetings.create')->with([
            'internal_audits' => $internal_audits,
            'coto_issues' => $coto_issues,
            'colors' => Config::get('color.user_colors'),
            'capas' => $capas,
            'education' => $education,
            'suppliers' => $suppliers,
            'processes' => $processes
        ]);
    }

    public function store(Request $request)
    {
        $req = $request->all();

        $management_review_meeting = ManagementReviewMeeting::create($req);

        $attendances = explode(',', $req['attendance']);
        $absents = explode(',', $req['absent']);

        foreach ($attendances as $atendance) {
            $management_review_meeting->attendances()->attach(Role::findOrFail($atendance));
        }

        foreach ($absents as $absent) {
            $management_review_meeting->absents()->attach(Role::findOrFail($absent));
        }

        foreach ($req['processes'] as $process) {
            $process['management_review_id'] = $management_review_meeting->id;
            $process_item = ManagementReviewProcess::create($process);
        }

        // log
        loggr(trans('log.:user a adăugat ședinta procesului verbal al ședinței de examinare nr :management_review_meeting', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'management_review_meeting' =>  $management_review_meeting->id]), Auth::id(), '{"entity_type": "' . get_class($management_review_meeting) . '", "entity_id": ' . $management_review_meeting->id . '}');

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ManagementReviewMeetingsController@view', $management_review_meeting->id);
    }

    public function get_roles()
    {
        $term = Input::get('q');

        $roles = Role::where('name', 'LIKE', '%' . $term . '%')->get();

        return $roles;
    }

    public function to_capa(Request $request)
    {
        $req = $request->all();

        $item = Capa::create([
            'type' => 'corrective_action',
            'source' => 'internal_audit_finding',
            'process_id' => $req['process_id'],
            'priority' => 'high',
            'description' => $req['description'],
            'user_id' => Auth::user()->id
        ]);

        // log
        loggr(trans('log.:user a adăugat acțiune preventivă și corectivă cu nr. :capa', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'capa' => '<a href="' . action('CapasController@edit', $item->id) . '" target="_blank">' . $item->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return 'true';
    }
}
