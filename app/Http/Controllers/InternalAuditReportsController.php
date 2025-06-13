<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Role;
use App\Models\Capa;
use App\Models\Standard;
use App\Models\InternalAudit;
use App\Models\StandardChapter;
use App\Models\InternalAuditReport;
use App\Models\InternalAuditReportDoc;
use App\Models\InternalAuditReportAudit;
use App\Models\InternalAuditReportReview;

use App\Http\Requests;
use Carbon\Carbon;

class InternalAuditReportsController extends Controller
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

    public function view($id)
    {
        $internal_audit = InternalAudit::findOrFail($id);
        $internal_audit_report = InternalAuditReport::where('internal_audit_id', $internal_audit->id)->first();
        $standards = Standard::all();
        $processes = [];

        foreach ($internal_audit->process as $internal_process) {
            $processes[] = $internal_process->process;
        }

        return view('internal_audit_reports.view')->with([
            'internal_audit' => $internal_audit,
            'internal_audit_report' => $internal_audit_report,
            'standards' => $standards,
            'processes' => $processes
        ]);
    }

    /**
     * Show the form for creating a new Internal audit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $internal_audit = InternalAudit::findOrFail($id);
        $standards = Standard::all();
        $processes = [];

        foreach ($internal_audit->process as $internal_process) {
            $processes[] = $internal_process->process;
        }

        return view('internal_audit_reports.create')->with([
            'internal_audit' => $internal_audit,
            'standards' => $standards,
            'processes' => $processes
        ]);
    }

    public function store(Request $request, $id)
    {
        $req = $request->all();

        $internal_audit = InternalAudit::findOrFail($id);

        $req['internal_audit_id'] = $id;

        $internal_audit_report = InternalAuditReport::create($req);

        $audited_people = explode(',', $req['audited_people']);

        foreach ($audited_people as $people) {
            $internal_audit_report->roles()->attach(Role::findOrFail($people));
        }

        for ($i = 0; $i < count($req['documentation_question']); $i++) {
            InternalAuditReportDoc::create([
                'internal_audit_report_id' => $internal_audit_report->id,
                'documentation_question' => $req['documentation_question'][$i],
                'documentation_yes_no' => $req['documentation_yes_no'][$i],
                'documentation_proof_or_note' => $req['documentation_proof_or_note'][$i]
            ]);
        }

        for ($i = 0; $i < count($req['audit_question']); $i++) {
            $internal_audit_report_audit = InternalAuditReportAudit::create([
                'internal_audit_report_id' => $internal_audit_report->id,
                'audit_question' => $req['audit_question'][$i],
                'audit_yes_no' => $req['audit_yes_no'][$i],
                'audit_proof_or_note' => $req['audit_proof_or_note'][$i],
            ]);

            $requirements = explode(',', $req['audit_requirement'][$i]);
            foreach ($requirements as $requirment) {
                $internal_audit_report_audit->requirements()->attach(StandardChapter::findOrFail($requirment));
            }
        }

        for ($i = 0; $i < count($req['review_report_question']); $i++) {
            InternalAuditReportReview::create([
                'internal_audit_report_id' => $internal_audit_report->id,
                'review_report_question' => $req['review_report_question'][$i],
                'review_report_yes_no' => $req['review_report_yes_no'][$i],
                'review_report_proof_or_note' => $req['review_report_proof_or_note'][$i]
            ]);
        }

        $internal_audit->update(['date_conducted' => Carbon::now()->toDateString()]);

        // log
        loggr(trans('log.:user a adăugat raportul de audit intern :internal_audit_report', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'internal_audit_report' =>  $internal_audit->audit]), Auth::id(), '{"entity_type": "' . get_class($internal_audit_report) . '", "entity_id": ' . $internal_audit_report->id . '}');

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('InternalAuditReportsController@view', $internal_audit->id);

    }

    public function get_roles()
    {
        $term = Input::get('q');

        $roles = Role::where('name', 'LIKE', '%' . $term . '%')->get();

        return $roles;
    }

    public function get_chapters($id)
    {
        $term = Input::get('q');
        $internal_audit = InternalAudit::findOrFail($id);
        $chapters = [];

        foreach ($internal_audit->process as $internal_process) {
            $chapters_object = $internal_process->process->chapters()->where('chapter_title', 'LIKE', '%' . $term . '%')->get();
            foreach ($chapters_object as $chapter) {
                $chapter->name = $chapter->chapter_title;
                $chapters[] = $chapter;
            }

            foreach ($internal_process->process->sub_process as $sub_process) {
                $chapters_object = $sub_process->chapters()->where('chapter_title', 'LIKE', '%' . $term . '%')->get();
                foreach ($chapters_object as $chapter) {
                    $chapter->name = $chapter->chapter_title;
                    $chapters[] = $chapter;
                }
            }
        }

        return $chapters;

    }

    public function to_capa(Request $request)
    {
        $req = $request->all();

        $internal_audit = InternalAudit::findOrFail($req['audit_id']);

        foreach ($internal_audit->process as $internal_audit_process) {
            $item = Capa::create([
                'type' => 'corrective_action',
                'source' => 'internal_audit_finding',
                'process_id' => $internal_audit_process->process->id,
                'priority' => 'high',
                'description' => $req['proof'],
                'user_id' => Auth::user()->id
            ]);

            // log
            loggr(trans('log.:user a adăugat acțiune preventivă și corectivă cu nr. :capa', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'capa' => '<a href="' . action('CapasController@edit', $item->id) . '" target="_blank">' . $item->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');
        }

        return 'true';
    }
}
