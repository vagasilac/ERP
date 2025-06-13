<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Machine;
use App\Models\MachineDocument;
use App\Models\MachineTimeTracking;
use App\Models\ProjectCalculationsSetting;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MachinesController extends Controller
{
    var $items_per_page;

    public function __construct()
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
     * Display a listing of the machines.
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        if (!hasPermission('Machines list')) {
            abort(401);
        }

        $machine_obj = Machine::query();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $machine_obj = $machine_obj->where('name', 'LIKE', '%' . $request->input('search') . '%');
            $machine_obj = $machine_obj->orWhere('observations', 'LIKE', '%' . $request->input('search') . '%');
            $machine_obj = $machine_obj->orWhere('type', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'maintenance_log') {
                $machine_obj = $machine_obj->orderByRaw(
                    "CASE maintenance_log
                    WHEN 'abkant' THEN 1
                    WHEN 'electrical_welding_apparatus' THEN 2
                    WHEN 'tig_mig_mag_welding_machine' THEN 3
                    WHEN 'disk_saws' THEN 4
                    WHEN 'cutting_saw' THEN 5
                    WHEN 'stinging_scissors' THEN 6
                    WHEN 'drilling' THEN 7
                    WHEN 'general' THEN 8
                    WHEN 'guillotine' THEN 9
                    WHEN 'bending' THEN 10
                    WHEN 'rotary_table' THEN 11
                    WHEN 'double_fixed_sander' THEN 12
                    WHEN 'presser' THEN 13
                    WHEN 'roll_trained' THEN 14
                    WHEN 'chamfering' THEN 15
                    WHEN 'polishing' THEN 16
                    WHEN 'woodturning' THEN 17
                    WHEN 'transpalet' THEN 18
                    END " . $request->input('sort_direction')
                );
            }
            else if ($request->input('sort') == 'operation') {
                $machine_obj = $machine_obj->join('project_calculations_settings', 'machines.operation_id', '=', 'project_calculations_settings.id');
                $machine_obj = $machine_obj->orderBy('project_calculations_settings.name', $request->input('sort_direction'));
            }
            else {
                $machine_obj = $machine_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }

        }
        else {
            $machine_obj->orderBy('inventory_no', 'DESC');
        }

        $items = $machine_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('ims.machines._machines_list');
        }
        else {
            $view = view('ims.machines.index');
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
     * Show the form for creating a new machine.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Machines add')) {
            abort(401);
        }

        return view('ims.machines.create')->with('operations', ProjectCalculationsSetting::where('type', 'operation')->lists('name', 'id'));
    }

    /**
     * Store a newly created machine in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'hourly_rate' => 'numeric',
            'inventory_no' => 'required',
            'manufacturing_year' => 'date_format:Y',
            'name' => 'required|max:255',
            'power' => 'numeric'
        ]);

        $item = Machine::create($request->all());

        // upload file if necessary
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $item->id . '.' . $extension;

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/machines/' . $item->id . '/photos')) {
                Storage::makeDirectory('ims/machines/' . $item->id . '/photos');
            }
            if (!Storage::exists('ims/machines/' . $item->id . '/photos/thumbs')) {
                Storage::makeDirectory('ims/machines/' . $item->id . '/photos/thumbs');
            }

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/ims/machines/' . $item->id . '/photos/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/ims/machines/' . $item->id . '/photos/thumbs/' . $filename), 70);

            $item->photo = $filename;
            $item->save();
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat utilajul :machine', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'machine' => '<a href="' . action('MachinesController@edit', $item->id) . '" target="_blank">' . $item->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('MachinesController@edit', $item->id);
    }

    /**
     * Display the specified machine.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified machine.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Machines edit')) {
            abort(401);
        }

        $item = Machine::findOrFail($id);

        return view('ims.machines.edit')->with([
            'file_type_colors' => Config::get('color.file_type_colors'),
            'item' => $item,
            'operations' => ProjectCalculationsSetting::where('type', 'operation')->lists('name', 'id'),
            'machine_manual_documents' => MachineDocument::where('machine_id', $id)->where('type', 'machine_manual')->get(),
            'revision_documents' => MachineDocument::where('machine_id', $id)->where('type', 'revision')->get(),
            'photos' => MachineDocument::where('machine_id', $id)->where('type', 'photo')->get()
        ]);
    }

    /**
     * Update the specified machine in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hourly_rate' => 'numeric',
            'inventory_no' => 'required',
            'manufacturing_year' => 'date_format:Y',
            'name' => 'required|max:255',
            'power' => 'numeric'
        ]);

        $item = Machine::findOrFail($id);
        $item->update($request->all());

        // upload file if necessary
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $item->id . '.' . $extension;

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/machines/' . $item->id . '/photos')) {
                Storage::makeDirectory('ims/machines/' . $item->id . '/photos');
            }
            if (!Storage::exists('ims/machines/' . $item->id . '/photos/thumbs')) {
                Storage::makeDirectory('ims/machines/' . $item->id . '/photos/thumbs');
            }

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/ims/machines/' . $item->id . '/photos/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/ims/machines/' . $item->id . '/photos/thumbs/' . $filename), 70);



            $item->photo = $filename;
            $item->save();
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat utilajul :machine', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'machine' => '<a href="' . action('MachinesController@edit', $item->id) . '" target="_blank">' . $item->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('MachinesController@edit', $id);
    }

    /**
     * Remove the specified machine from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Machine::findOrFail($id);
        $item->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        //log
        loggr(trans('log.:user a șters utilajul :machine', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'machine' => $item->name]), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('Machine@index');
    }

    /**
     * Multiple remove of machines from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function multiple_destroy(Request $request)
    {
        $names = '';
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $item = Machine::findOrFail($id);
                $names .= $item->name . ', ';
                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));


            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters utilajele :machine', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'machine' => $names]), Auth::id(), '{"entity_type": "' . Machine::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('MachinesController@index');

    }

    /**
     * Remove the specified machine's photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo($id)
    {
        $item = Machine::findOrFail($id);

        if ($item->photo && Storage::exists('ims/machines/' . $item->id . '/photos' . $item->photo)) {
            Storage::delete(['ims/machines/' . $item->id . '/photos/' . $item->photo, 'ims/machines/' . $item->id . '/photos/thumbs/' . $item->photo]);
        }

        $photo_name = $item->photo;
        $item->photo = null;
        $item->save();

        //log
        loggr(trans('log.:user a șters photografia :photo', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'photo' => $photo_name]), Auth::id(), '{"entity_type": "' . Machine::class . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('MachinesController@edit', $id);
    }

    /**
     * Upload documents for a machine
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = Machine::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/machines/' . $id . '/documents')) {
                Storage::makeDirectory('ims/machines/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('ims/machines/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('ims/machines/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'ims/machines/' . $id . '/documents/' . $filename]);

            MachineDocument::create([
                'machine_id' => $item->id,
                'name' => $filename,
                'file_id' => $new_file->id,
                'type' => $input['type']
            ]);

            //log
            loggr(trans('log.:user a încărcat documentul :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => '<a href="' . action('FilesController@show', ['id' => $new_file->id, 'name' => $filename]) . '" target="_blank">' . $filename . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $new_file->id . '}');
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
                $document = MachineDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . Machine::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('MachinesController@edit', $id);

    }

    /**
     * Generate QR code labels
     *
     * @param $id
     * @return mixed
     */
    public function qr_label($id) {
        $machine = Machine::findOrFail($id);

        config(['dompdf.defines.DOMPDF_DPI' => 300]);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('pdf.machine_qr_label', ['machine' => $machine]);

        return $pdf->stream();
    }

    public function maintenance($id)
    {
        if (!hasPermission('Machines - view maintenance calendar')) {
            abort(401);
        }

        $item = Machine::findOrFail($id);

        return view('ims.machines.maintenance')->with([
            'item' => $item
        ]);
    }

    /**
     * Return machine's maintenance events
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function maintenance_events($id) {
        /*
         * START QUICKFIX  // @TODO Peter: remove
         */
        MachineTimeTracking::truncate();

        $holidays = [
            Carbon::createFromDate(2017,  1,  1),
            Carbon::createFromDate(2017,  1,  2),
            Carbon::createFromDate(2017,  1, 24),
            Carbon::createFromDate(2017,  4, 16),
            Carbon::createFromDate(2017,  4, 17),
            Carbon::createFromDate(2017,  5,  1),
            Carbon::createFromDate(2017,  6,  1),
            Carbon::createFromDate(2017,  6,  4),
            Carbon::createFromDate(2017,  6,  5),
            Carbon::createFromDate(2017,  8, 15),
            Carbon::createFromDate(2017, 11, 30),
            Carbon::createFromDate(2017, 12,  1),
            Carbon::createFromDate(2017, 12, 25),
            Carbon::createFromDate(2017, 12, 26),
        ];

        $day = Carbon::createFromDate(2017, 01, 01);

        // iterate over days until today
        while ($day < Carbon::now()) {
            // check if not weekend or holiday
            if ($day->dayOfWeek != 6 && $day->dayOfWeek != 0 && !in_array($day, $holidays)) {
                // instantiate hours
                $hour_start = Carbon::createFromTime(rand(8, 14), rand(0, 59), rand(0, 59));
                $hour_end = $hour_start->copy();
                $hour_end->addMinutes(rand(10, 45));

                // check if quarterly maintenance
                if (($day->month == 2 && $day->day == 10) || ($day->month == 5 && $day->day == 10))
                    $frequency = 'quarterly';
                // check if monthly maintenance
                else if (($day->month != 6 && $day->day == 10) || ($day->month == 6 && $day->day == 9))
                    $frequency = 'monthly';
                // check if weekly maintenance
                else if ($day->dayOfWeek == 2)
                    $frequency = 'weekly';
                else
                    $frequency = 'daily';

                // add events
                MachineTimeTracking::create([
                    'machine_id' => $id,
                    'operation' => 'maintenance',
                    'frequency' => $frequency,
                    'type' => 'start',
                    'note' => '',
                    'created_at' => Carbon::create($day->year, $day->month, $day->day, $hour_start->hour, $hour_start->minute, $hour_start->second)->toDateTimeString(),
                    'updated_at' => Carbon::create($day->year, $day->month, $day->day, $hour_start->hour, $hour_start->minute, $hour_start->second)->toDateTimeString()
                ]);
                MachineTimeTracking::create([
                    'machine_id' => $id,
                    'operation' => 'maintenance',
                    'frequency' => $frequency,
                    'type' => 'stop',
                    'note' => '',
                    'created_at' => Carbon::create($day->year, $day->month, $day->day, $hour_end->hour, $hour_end->minute, $hour_end->second)->toDateTimeString(),
                    'updated_at' => Carbon::create($day->year, $day->month, $day->day, $hour_end->hour, $hour_end->minute, $hour_end->second)->toDateTimeString()
                ]);
            }

            $day->addDay();
        }
        /*
         * END QUICKFIX
         */

        $time_tracking = MachineTimeTracking::where('machine_id', $id)->orderBy('created_at')->get();
        $frequencies = Config::get('machines.frequency');

        $time_tracking_by_operation = [];
        $events_array = [];

        if (count($time_tracking) > 0) {
            foreach ($time_tracking as $item) {
                $time_tracking_by_operation[$item->operation][$item->frequency][] = ['type' => $item->type, 'date' => Carbon::parse($item->created_at), 'supplier_id' => $item->supplier_id, 'user_id' => $item->user_id];
            }
        }

        if (count($time_tracking_by_operation) > 0) {
            foreach ($time_tracking_by_operation as $operation_key => $operation) {
                if (count($operation) > 0) {
                    foreach ($operation as $frequency_key => $frequency) {
                        if (count($frequency) > 0) {
                            foreach ($frequency as $k => $item) {
                                if ($item['type'] == 'start') {
                                    $end_date = isset($frequency[$k+1]) && ($frequency[$k+1]['type'] == 'stop' || $frequency[$k+1]['type'] == 'pause') ? $frequency[$k+1]['date']->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
                                    $by = '';
                                    if (!is_null($item['supplier_id'])) {
                                        $supplier = Supplier::find($item['supplier_id']);
                                        $by = !is_null($supplier) ? $supplier->name : '';
                                    }
                                    elseif (!is_null($item['user_id'])) {
                                        $user = User::find($item['user_id']);
                                        $by = !is_null($user) ? $user->name() : '';
                                    }
                                    $events_array[] = ['id' => $id . $operation_key . $frequency_key, 'start' => $item['date']->format('Y-m-d H:i:s'), 'end' => $end_date, 'title' => ($operation_key == 'repair' ? 'Reparație' : 'Mentenanță') . ($frequency_key != '' ? ' / ' . $frequencies[$frequency_key] : ''), 'color' => Config::get('color.machine_maintenance')[$operation_key == 'repair' ? 'repair' : $frequency_key], 'by' => $by];
                                }
                            }

                        }
                    }
                }

            }
        }

        return response()->json($events_array, 200);
    }
}
