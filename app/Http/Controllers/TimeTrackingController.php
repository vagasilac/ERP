<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineDocument;
use App\Models\MachineTimeTracking;
use App\Models\Project;
use App\Models\ProjectCalculationsSetting;
use App\Models\ProjectSubassembly;
use App\Models\ProjectTimeTracking;
use C4studio\Loggr\Loggr;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TimeTrackingController extends Controller
{
    var $items_per_page;

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display the time tracking form
     *
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('time_tracking.index');
    }


    /**
     * Read QR code
     */
    public function qr_read()
    {
        $results = array();
        if (Input::has('qr_code')) {
            if (ctype_xdigit(Input::get('qr_code')) && (strlen(Input::get('qr_code')) % 2 == 0)) { //hexadecimal
                $code = hex2bin(Input::get('qr_code'));
                $code_parts = explode('|', $code);

                $info = '';
                if (isset($code_parts[0])) {
                    $results['last_action'] = '';

                    // projects
                    if ($code_parts[0] == 'project') {
                        $results['type'] = 'project';

                        // project id
                        if (isset($code_parts[1])) {
                            $project = Project::find($code_parts[1]);
                            if (!is_null($project)) {
                                $info = $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name;
                                $results['project_id'] = $project->id;
                            }
                        }

                        // subassembly id
                        if (isset($code_parts[2])) {
                            $info = $info . ' / ' . ProjectSubassembly::find($code_parts[2])->name;
                            $results['subassembly_id'] = $code_parts[1];

                            // last action
                            $last_action = ProjectTimeTracking::where('subassembly_id', $code_parts[1])->where('user_id', Auth::id())->where('operation_slug', isset($code_parts[4]) ? $code_parts[4] : '')->orderBy('created_at', 'DESC')->first();
                            if (!is_null($last_action)) {
                                $results['last_action'] = $last_action['type'];
                            }

                        }

                        // operation name
                        if (isset($code_parts[3])) {
                            $info = $info . ' / ' . $code_parts[3];
                            $results['operation_name'] = $code_parts[3];
                        }

                        // operation slug
                        if (isset($code_parts[4])) {
                            $results['operation_slug'] = $code_parts[4];
                        }


                    }
                    // machine
                    elseif ($code_parts[0] == 'machine') {
                        $results['type'] = 'machine';

                        // machine id
                        if (isset($code_parts[1])) {
                            $machine = Machine::find($code_parts[1]);
                            if (!is_null($machine)) {
                                $info = $machine->name;
                                $results['machine_id'] = $machine->id;
                            }

                            // last action
                            $last_action = MachineTimeTracking::where('machine_id', $machine->id)->where('user_id', Auth::id())->where('operation', $code_parts[2])->orderBy('created_at', 'DESC')->first();
                            if (!is_null($last_action)) {
                                $results['last_action'] = $last_action['type'];
                            }
                        }

                        // operation type
                        if (isset($code_parts[2])) {
                            $info = $info . ($code_parts[2] == 'repair' ? ' / Reparație' : ($code_parts[2] == 'maintenance' ? ' / Mentenanță' : ''));
                            $results['operation_type'] = $code_parts[2];
                        }

                        // frequency
                        if (isset($code_parts[3])) {
                            $frequency = Config::get('machines.frequency');
                            $info = $info . ' / ' . $frequency[$code_parts[3]];
                            $results['frequency'] = $code_parts[3];
                        }

                    }
                }
                $results['info'] = $info;

            }
        }

        echo json_encode($results);
    }

    /**
     * Store time tracking
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function qr_tracking_store(Request $request)
    {
        $req = $request->all();
        if (isset($req['data'])) {
            $data = json_decode(trim(str_replace('\"', '"', $req['data']), '"'));

            if (isset($data->type)) {
                switch ($data->type) {
                    case 'project':

                        $max_quantity = '';
                        if (isset($data->subassembly_id)) {
                            $subassembly = ProjectSubassembly::find($data->subassembly_id);
                            $max_quantity = $subassembly->quantity;

                        }

                        $this->validate($request, [
                            'completed_items_no' => 'numeric|min:0' . ($max_quantity != '' ? '|max:' . $max_quantity : ''),
                            'in_process_item_percentage' => 'numeric|min:0|max:100'
                        ]);

                        $req['user_id'] = Auth::id();
                        $req['project_id'] = $data->project_id;
                        $req['subassembly_id'] = $data->subassembly_id;
                        $req['operation_name'] = $data->operation_name;
                        $req['operation_slug'] = $data->operation_slug;

                        ProjectTimeTracking::create($req);

                        Session::flash('success_msg', trans('Înregistrarea a fost adăugată cu succes'));

                        return redirect()->action('TimeTrackingController@index');

                        break;
                    case 'machine':

                        $req['machine_id'] = $data->machine_id;
                        $req['operation'] = $data->operation_type;
                        $req['frequency'] = isset($data->frequency) ? $data->frequency : null;
                        $req['user_id'] = Auth::id();

                        MachineTimeTracking::create($req);

                        Session::flash('success_msg', trans('Înregistrarea a fost adăugată cu succes'));

                        return redirect()->action('TimeTrackingController@index');

                        break;
                }
            }
        }

        Session::flash('error_msg', trans('Eroare! Înregistrarea nu a fost adăugată'));

        return redirect()->action('TimeTrackingController@index');
    }


}
