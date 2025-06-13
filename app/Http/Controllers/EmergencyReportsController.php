<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\EmergencyReport;
use App\Models\EmergencyReportCommission;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use Carbon\Carbon;

class EmergencyReportsController extends Controller
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

    /**
     * Show the form for creating a new Emergency report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Emergency report add')) {
            abort(401);
        }

        return view('emergency_reports.create');
    }

    /**
     * Store a newly created Emergency Report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'location' => 'required',
            'cause' => 'required',
            'consequenc' => 'required',
            'plan' => 'required',
            'take_action' => 'required',
            'intervention_team_plan' => 'required',
            'requirements_for_intervention' => 'required',
            'required_measures' => 'required',
            'revision_responsible_emergency_plan' => 'required',
            'process_date' => 'required'
        ]);

        $req = $request->all();

        $req['process_date'] = Carbon::createFromFormat('d-m-Y H:i', $req['process_date'])->toDateTimeString();
        $req['required_measures_deadlin'] = Carbon::createFromFormat('d-m-Y', $req['required_measures_deadlin'])->toDateTimeString();
        $req['revision_responsible_emergency_plan_deadlin'] = Carbon::createFromFormat('d-m-Y', $req['revision_responsible_emergency_plan_deadlin'])->toDateTimeString();
        $req['elaborate_user_id'] = Auth::id();
        $req['verified_user_id'] = null;
        $req['approved_user_id'] = null;

        $item = EmergencyReport::create($req);

        foreach ($request['member_id'] as $member_id) {
            $commision['emergency_report_id'] = $item->id;
            $commision['user_id'] = $member_id;
            EmergencyReportCommission::create($commision);
        }



        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat raport de urgență cu nr. :raport', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'raport' =>  $item->id]), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('EmergencyReportsController@edit', $item->id);
    }

    /**
     * Show the form for editing the Emergency Report.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Emergency report edit')) {
            abort(401);
        }

        $item = EmergencyReport::findOrFail($id);

        $members = EmergencyReportCommission::where('emergency_report_id', $id)->get();

        return view('emergency_reports.edit')->with('item', $item)->with('members', $members)->with('colors', Config::get('color.user_colors'));
    }

    /**
     * Verified by user
     * @param  int $id
     * @return \inate\Http\Response
     */
    public function verified($id)
    {
        if (!hasPermission('Emergency report verification')) {
            abort(401);
        }

        $item = EmergencyReport::findOrFail($id);

        $item->verified_user_id = Auth::id();
        $item->verified = true;
        $item->verified_date_time = Carbon::now();

        $item->save();

        // log
        loggr(trans('log.:user a verificat raport de urgență cu nr. :raport', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'raport' =>  $item->id]), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('EmergencyReportsController@edit', $id);

    }

    /**
     * Approved by user
     * @param  int $id
     * @return \inate\Http\Response
     */
    public function approved($id)
    {
        if (!hasPermission('Emergency report approval')) {
            abort(401);
        }

        $item = EmergencyReport::findOrFail($id);

        $item->approved_user_id = Auth::id();
        $item->approved = true;
        $item->approved_date_time = Carbon::now();

        $item->save();

        // log
        loggr(trans('log.:user a aprobat raport de urgență cu nr. :raport', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'raport' =>  $item->id]), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('EmergencyReportsController@edit', $id);
    }
}
