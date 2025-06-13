<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Role;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Education;
use App\Models\Participant;

use App\Http\Requests;
use Carbon\Carbon;

class EducationController extends Controller
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
     * Display a listing of Education
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!hasPermission('Education list')) {
            abort(401);
        }

        $education = Education::where('nr', 'NOT LIKE', '%ind%')->get();

        return view('education.index')->with('education', $education);
    }

    /**
     * Store a newly created Education with one participant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $req = $request->all();

        $year = Carbon::now()->year;
        $year = substr($year, 2);


        if ($req['trainer_id'] != '') {
            switch ($req['trainer_id'][0]) {
                case 'r': {
                    $req['role_id'] = substr($req['trainer_id'], 1);
                    $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%int%')->get()->count() + 1;
                    $req['nr'] = 'int-' . $year . '-' . $count;
                    break;
                }
                case 's': {
                    $req['supplier_id'] = substr($req['trainer_id'], 1);
                    $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%int%')->get()->count() + 1;
                    $req['nr'] = 'int-' . $year . '-' . $count;
                    break;
                }
            }
        }
        else {
            $supplier = Supplier::create(['name' => $req['trainer']]);
            $req['supplier_id'] = $supplier->id;
            $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%ext%')->get()->count() + 1;
            $req['nr'] = 'ext-' . $year . '-' . $count;

            // log
            loggr(trans('log.:user a adăugat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');
        }

        $planed = explode(' - ', $req['planned_interval']);
        $req['planned_start_date'] = Carbon::createFromFormat('d-m-Y', $planed[0])->toDateString();
        $req['planned_finish_date'] = Carbon::createFromFormat('d-m-Y', $planed[1])->toDateString();

        $accomplished = explode(' - ', $req['accomplished_interval']);
        $req['accomplished_start_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[0])->toDateString();
        $req['accomplished_finish_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[1])->toDateString();

        $education = Education::create($req);

        Participant::create(['education_id' => $education->id, 'user_id' => $id]);

        // log
        loggr(trans('log.:user a adăugat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $id . '}');

        Session::flash('success_msg', trans('Instruirea a fost adăugat'));

        return redirect()->action('UsersController@edit', $id);
    }

    /**
     * Store a newly created Education with more participants in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiple_store(Request $request)
    {
        $req = $request->all();

        $year = Carbon::now()->year;
        $year = substr($year, 2);

        if ($req['trainer_id'] != '') {
            switch ($req['trainer_id'][0]) {
                case 'r': {
                    $req['role_id'] = substr($req['trainer_id'], 1);
                    $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%int%')->get()->count() + 1;
                    $req['nr'] = 'int-' . $year . '-' . $count;
                    break;
                }
                case 's': {
                    $req['supplier_id'] = substr($req['trainer_id'], 1);
                    $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%int%')->get()->count() + 1;
                    $req['nr'] = 'int-' . $year . '-' . $count;
                    break;
                }
            }
        }
        else {
            $supplier = Supplier::create(['name' => $req['trainer']]);
            $req['supplier_id'] = $supplier->id;
            $count = Education::where('created_at', 'LIKE', '%' . $year . '%')->where('nr', 'LIKE', '%ext%')->get()->count() + 1;
            $req['nr'] = 'ext-' . $year . '-' . $count;

            // log
            loggr(trans('log.:user a adăugat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');
        }

        $planed = explode(' - ', $req['planned_interval']);
        $req['planned_start_date'] = Carbon::createFromFormat('d-m-Y', $planed[0])->toDateString();
        $req['planned_finish_date'] = Carbon::createFromFormat('d-m-Y', $planed[1])->toDateString();

        $accomplished = explode(' - ', $req['accomplished_interval']);
        $req['accomplished_start_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[0])->toDateString();
        $req['accomplished_finish_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[1])->toDateString();

        $education = Education::create($req);

        if (isset($req['all_user'])) {
            foreach (User::all() as $user) {
                Participant::create(['education_id' => $education->id, 'user_id' => $user->id]);
            }
        }
        else {
            $users = explode(',', $req['participants']);

            foreach ($users as $user) {
                Participant::create(['education_id' => $education->id, 'user_id' => $user]);
            }
        }

        Session::flash('success_msg', trans('Instruirea a fost adăugat'));

        // log
        loggr(trans('log.:user a adăugat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $education->id . '}');

        return redirect()->action('EducationController@index');

    }

    /**
     * Update the specified Education with one participant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = $request->all();

        $education = Education::findOrFail($id);

        if ($req['trainer_id'] != '') {
            switch ($req['trainer_id'][0]) {
                case 'r': {
                    $req['role_id'] = substr($req['trainer_id'], 1);
                    $req['supplier_id'] = null;
                    break;
                }
                case 's': {
                    $req['supplier_id'] = substr($req['trainer_id'], 1);
                    $req['role_id'] = null;
                    break;
                }
            }
        }
        else {
            $supplier = Supplier::create(['name' => $req['trainer']]);
            $req['supplier_id'] = $supplier->id;
            $req['role_id'] = null;

            // log
            loggr(trans('log.:user a adăugat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');
        }

        $planed = explode(' - ', $req['planned_interval']);
        $req['planned_start_date'] = Carbon::createFromFormat('d-m-Y', $planed[0])->toDateString();
        $req['planned_finish_date'] = Carbon::createFromFormat('d-m-Y', $planed[1])->toDateString();

        $accomplished = explode(' - ', $req['accomplished_interval']);
        $req['accomplished_start_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[0])->toDateString();
        $req['accomplished_finish_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[1])->toDateString();

        $education->update($req);

        Session::flash('success_msg', trans('Instruirea a fost editat'));

        // log
        loggr(trans('log.:user a editat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $education->id . '}');

        return redirect()->action('UsersController@edit', $education->participant[0]->user_id);
    }

    /**
     * Update the specified Education with more participants in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function multiple_update(Request $request, $id)
    {
        $req = $request->all();

        $education = Education::findOrFail($id);

        if ($req['trainer_id'] != '') {
            switch ($req['trainer_id'][0]) {
                case 'r': {
                    $req['role_id'] = substr($req['trainer_id'], 1);
                    $req['supplier_id'] = null;
                    break;
                }
                case 's': {
                    $req['supplier_id'] = substr($req['trainer_id'], 1);
                    $req['role_id'] = null;
                    break;
                }
            }
        }
        else {
            $supplier = Supplier::create(['name' => $req['trainer']]);
            $req['supplier_id'] = $supplier->id;
            $req['role_id'] = null;

            // log
            loggr(trans('log.:user a adăugat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');
        }

        $planed = explode(' - ', $req['planned_interval']);
        $req['planned_start_date'] = Carbon::createFromFormat('d-m-Y', $planed[0])->toDateString();
        $req['planned_finish_date'] = Carbon::createFromFormat('d-m-Y', $planed[1])->toDateString();

        $accomplished = explode(' - ', $req['accomplished_interval']);
        $req['accomplished_start_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[0])->toDateString();
        $req['accomplished_finish_date'] = Carbon::createFromFormat('d-m-Y', $accomplished[1])->toDateString();

        $education->update($req);

        $users = [];

        if (isset($req['all_user'])) {
            $user_objects = User::all();

            foreach ($user_objects as $user) {
                $users[] = $user->id;
            }
        }
        else {
            $users = explode(',', $req['participants']);
        }

        $current_users = [];
        $participants = $education->participant()->select('user_id')->get()->toArray();

        foreach ($participants as $participant) {
            $current_users[] = $participant['user_id'];
        }

        foreach ($users as $user) {
            if (!in_array($user, $current_users)) {
                Participant::create(['education_id' => $id, 'user_id' => $user]);
            }
        }

        foreach ($current_users as $user) {
            if (!in_array($user, $users)) {
                Participant::where('user_id', $user)->where('education_id', $id)->delete();
            }
        }

        Session::flash('success_msg', trans('Instruirea a fost editat'));

        // log
        loggr(trans('log.:user a editat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $education->id . '}');

        return redirect()->action('EducationController@index');

    }

    /**
     * Trainer confirmation
     * @return \Illuminate\Http\Response
     */
    public function trainer_confirm($id)
    {
        $education = Education::findOrFail($id);
        $education->trainer_confirmed = true;
        $education->save();

        Session::flash('success_msg', trans('Instruirea a fost confirmat'));

        // log
        loggr(trans('log.:user a confirmat instruirea :education ca trainer', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $education->id . '}');

        return redirect()->action('UsersController@edit', Auth::user()->id);
    }

    /**
     * User confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmed($id)
    {
        $participant = Participant::where('education_id', $id)->where('user_id', Auth::user()->id)->first();

        $education = Education::findOrFail($id);

        $participant->user_confirmed = true;
        $participant->save();

        // log
        loggr(trans('log.:user a confirmat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $id . '}');

        Session::flash('success_msg', trans('Instruirea a fost confirmat'));

        return redirect()->action('EducationController@index');
    }

    /**
     * Return trainers list
     * @return array $trainers
     */
    public function get_trainers()
    {
        $term = Input::get('q');

        $roles_obj = Role::select('name', DB::raw('CONCAT("r", id) AS trainer_id'))->where('name', 'LIKE', '%' . $term . '%')->orderBy('name')->get();

        $suppliers_obj = Supplier::select('name', DB::raw('CONCAT("s", id) AS trainer_id'))->where('name', 'LIKE', '%' . $term . '%')->orderBy('name')->get();

        $trainers = $roles_obj->toArray();
        $trainers = array_merge($trainers, $suppliers_obj->toArray());
        $trainers = collect($trainers);
        $trainers->sortBy('name');
        $trainers = $trainers->values()->all();
        return $trainers;
    }

    /**
     * Return a specified education in Json format.
     * @return Json $education
     */
    public function get_education(Request $request)
    {
        $education = Education::findOrFail($request->id);
        $education->certificate;
        $education->role;
        $education->supplier;
        $education->diplomas = $education->participant[0]->diploma();
        $education->users = $education->get_participant_users();

        return response()->json($education, 200);
    }

}
