<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ContractRegister;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\ContractRegisterDocument;

use App\Http\Requests;

class ContractRegisterController extends Controller
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
     * Display a listing of the contract registers items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('Contract registers list')) {
            abort(401);
        }

        $contract_registers_obj = ContractRegister::query();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $contract_registers_obj = $contract_registers_obj->where('nr_date_of_contract', 'LIKE', '%' . $request->input('search') . '%');
            $contract_registers_obj = $contract_registers_obj->orWhere('content', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'user') {
                $contract_registers_obj = $contract_registers_obj->join('users', 'contract_registers.user_id', '=', 'users.id');
                $contract_registers_obj = $contract_registers_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else {
                $contract_registers_obj = $contract_registers_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }

        }

        $items = $contract_registers_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('contract_registers._cr_list');
        }
        else {
            $view = view('contract_registers.index');
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
     * Show the form for creating a new contract register.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Contract registers add')) {
            abort(401);
        }

        return view('contract_registers.create');
    }

    /**
     * Store a newly created contract register in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nr_date_of_contract' => 'required',
            'content' => 'required',
            'partner' => 'required'
        ]);

        $req = $request->all();

        $req['user_id'] = Auth::user()->id;

        switch ($req['partner_id'][0]) {
            case 'c': {
                $req['customer_id'] = substr($req['partner_id'], 1);
                break;
            }
            case 's': {
                $req['supplier_id'] = substr($req['partner_id'], 1);
                break;
            }
        }

        $contract_registers = ContractRegister::create($req);

        Session::flash('success_msg', trans('Registrul contractului a fost adăugat'));

        // log
        loggr(trans('log.:user a adăugat registrul contractului cu nr :contract_registers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'contract_registers' => '<a href="' . action('ContractRegisterController@edit', $contract_registers->id) . '" target="_blank">' . $contract_registers->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($contract_registers) . '", "entity_id": ' . $contract_registers->id . '}');

        return redirect()->action('ContractRegisterController@edit', $contract_registers->id);
    }

    /**
     * Show the form for editing the specified contract register.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Contract registers edit')) {
            abort(401);
        }

        $item = ContractRegister::findOrFail($id);
        $documents = ContractRegisterDocument::where('contract_register_id', $id)->get();

        return view('contract_registers.edit')->with('item', $item)->with('documents', $documents);
    }

    /**
     * Update the specified contract register in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nr_date_of_contract' => 'required',
            'content' => 'required'
        ]);

        $req = $request->all();

        $contract_registers = ContractRegister::findOrFail($id);

        if ($req['partner_id'] != '') {
            switch ($req['partner_id'][0]) {
                case 'c': {
                    $req['customer_id'] = substr($req['partner_id'], 1);
                    $req['supplier_id'] = null;
                    break;
                }
                case 's': {
                    $req['supplier_id'] = substr($req['partner_id'], 1);
                    $req['customer_id'] = null;
                    break;
                }
            }
        }
        else {
            $req['customer_id'] = $contract_registers->customer_id;
            $req['supplier_id'] = $contract_registers->supplier_id;
        }

        $contract_registers->update($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat registrul contractului cu nr :contract_registers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'contract_registers' => '<a href="' . action('ContractRegisterController@edit', $contract_registers->id) . '" target="_blank">' . $contract_registers->id . '</a>']), Auth::id(), '{"entity_type": "' . get_class($contract_registers) . '", "entity_id": ' . $contract_registers->id . '}');

        return redirect()->action('ContractRegisterController@edit', $id);
    }

    /**
     * Multiple remove of contract register from storage.
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
                $item = ContractRegister::findOrFail($id);

                $names .= $item->id . ', ';

                // delete folder
                if (Storage::exists('contract_registers/'.$id))
                {
                    Storage::deleteDirectory('contract_registers/'.$id);
                }

                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters registrul contractului cu nr :contract_registers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'contract_registers' => $names]), Auth::id(), '{"entity_type": "' . ContractRegister::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('ContractRegisterController@index');
    }

    /**
     * Upload documents files for a Contract Register
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = ContractRegister::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('contract_registers/' . $id . '/documents')) {
                Storage::makeDirectory('contract_registers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('contract_registers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('contract_registers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'contract_registers/' . $id . '/documents/' . $filename]);

            ContractRegisterDocument::create([
                'contract_register_id' => $item->id,
                'name' => $filename,
                'file_id' => $new_file->id
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
                $document = ContractRegisterDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . ContractRegister::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('ContractRegisterController@edit', $id);

    }

    /**
     * Get receivers (suppliers and customers)
     *
     * @return array|\Illuminate\Support\Collection|static
     */
    public function get_receivers()
    {
        $term = Input::get('q');

        $customers_obj = Customer::select('name', DB::raw('CONCAT("c", id) AS receiver_id'))->where('name', 'LIKE', '%' . $term . '%')->orderBy('name')->get();

        $suppliers_obj = Supplier::select('name', DB::raw('CONCAT("s", id) AS receiver_id'))->where('name', 'LIKE', '%' . $term . '%')->orderBy('name')->get();

        $receivers = $customers_obj->toArray();
        $receivers = array_merge($receivers, $suppliers_obj->toArray());
        $receivers = collect($receivers);
        $receivers->sortBy('name');
        $receivers = $receivers->values()->all();
        return $receivers;
    }
}
