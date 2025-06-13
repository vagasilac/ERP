<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotoParty;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\CotoPartiesController;
use Illuminate\Support\Facades\Auth;

class CotoPartiesController extends Controller
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
    * Display a listing of the COTO Parties.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if (!hasPermission('Coto parties list')) {
            abort(401);
        }

        $coto_obj = CotoParty::query();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $coto_obj = $coto_obj->where('interested_party', 'LIKE', '%' . $request->input('search') . '%');
            $coto_obj = $coto_obj->orWhere('int_ext', 'LIKE', '%' . $request->input('search') . '%');
            $coto_obj = $coto_obj->orWhere('reason_for_inclusion', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            $coto_obj = $coto_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }
        else {
            $coto_obj = $coto_obj->orderBy('interested_party');
        }

        $items = $coto_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('coto_parties._cp_list');
        }
        else {
            $view = view('coto_parties.index');
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
     * Show the form for creating a new COTO party.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Coto parties add')) {
            abort(401);
        }

        return view('coto_parties.create');
    }

    /**
     * Store a newly created COTO party in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'interested_party' => 'required',
            'int_ext' => 'required',
            'reason_for_inclusion' => 'required'
        ]);

        $req = $request->all();

        if ($req['int_ext'] == 0) {
            $req['int_ext'] = 'internal';
        }
        else {
            $req['int_ext'] = 'external';
        }

        $item = CotoParty::create($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat contextul organizației parți :coto_parties', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_parties' => '<a href="' . action('CotoPartiesController@edit', $item->id) . '" target="_blank">' . $item->interested_party . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CotoPartiesController@edit', $item->id);
    }

    /**
     * Show the form for editing the specified COTO party.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Coto parties edit')) {
            abort(401);
        }

        $item = CotoParty::findOrFail($id);

        return view('coto_parties.edit')->with(['item' => $item]);
    }

    /**
     * Update the specified COTO party in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'interested_party' => 'required',
            'int_ext' => 'required',
            'reason_for_inclusion' => 'required'
        ]);

        $item = CotoParty::findOrFail($id);

        $req = $request->all();

        if ($req['int_ext'] == 0)
        {
            $req['int_ext'] = 'internal';
        }
        else
        {
            $req['int_ext'] = 'external';
        }

        $item->update($req);


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat contextul organizației parți :coto_parties', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_parties' => '<a href="' . action('CotoPartiesController@edit', $item->id) . '" target="_blank">' . $item->interested_party . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('CotoPartiesController@edit', $id);
    }

    /**
     * Multiple remove of COTO party from storage.
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
                $item = CotoParty::findOrFail($id);

                $names .= $item->interested_party . ', ';

                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters contexturile organizației parți :coto_parties', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'coto_parties' => $names]), Auth::id(), '{"entity_type": "' . CotoParty::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CotoPartiesController@index');

    }

    /**
     * Return COTO Parties list
     *
     * @return mixed
     */
    public function get_coto_parties() {
        $term = Input::get('q');

        $coto_obj = CotoParty::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $coto_obj = $coto_obj->where('interested_party' , 'LIKE', '%' . $term . '%');
        }

        $parties = $coto_obj->get();


        return $parties;
    }
}
