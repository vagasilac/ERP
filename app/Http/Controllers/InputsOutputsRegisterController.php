<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\InputsOutputsRegister;
use App\Models\InputsOutputsRegisterDocument;
use App\Models\Project;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class InputsOutputsRegisterController extends Controller
{
    private $items_per_page;

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
     * Display a listing of the IO items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('IO list')) {
            abort(401);
        }

        $io_obj = InputsOutputsRegister::query();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $io_obj = $io_obj->where('description', 'LIKE', '%' . $request->input('search') . '%');
            $io_obj = $io_obj->orWhere('receiver', 'LIKE', '%' . $request->input('search') . '%');
            $io_obj = $io_obj->orWhere('target', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'user') {
                $io_obj = $io_obj->join('users', 'inputs_outputs_register.user_id', '=', 'users.id');
                $io_obj = $io_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else {
                $io_obj = $io_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }

        }
        else {
            $io_obj->orderBy('number', 'DESC');
        }

        $items = $io_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('io_register._io_list');
        }
        else {
            $view = view('io_register.index');
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
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('IO add')) {
            abort(401);
        }

        return view('io_register.create');
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        $req = $request->all();

        if ($req['date'] != '') {
            $req['date'] = Carbon::createFromFormat('d-m-Y', $req['date'])->toDateTimeString();
        }
        else {
            $req['date'] = null;
        }
        if ($req['received_date'] != '') {
            $req['received_date'] = Carbon::createFromFormat('d-m-Y', $req['received_date'])->toDateTimeString();
        }
        else {
            $req['received_date'] = null;
        }
        $req['number'] = InputsOutputsRegister::max('number') + 1;
        $req['user_id'] = Auth::id();

        $item = InputsOutputsRegister::create($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('InputsOutputsRegisterController@edit', $item->id);
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('IO edit')) {
            abort(401);
        }

        $item = InputsOutputsRegister::findOrFail($id);

        return view('io_register.edit')->with([
            'file_type_colors' => Config::get('color.file_type_colors'),
            'item' => $item,
            'input_documents' => InputsOutputsRegisterDocument::where('io_register_id', $id)->where('type', 'input')->get(),
            'output_documents' => InputsOutputsRegisterDocument::where('io_register_id', $id)->where('type', 'output')->get(),
        ]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        $item = InputsOutputsRegister::findOrFail($id);

        $req = $request->all();

        if ($req['date'] != '') {
            $req['date'] = Carbon::createFromFormat('d-m-Y', $req['date'])->toDateTimeString();
        }
        else {
            $req['date'] = null;
        }
        if ($req['received_date'] != '') {
            $req['received_date'] = Carbon::createFromFormat('d-m-Y', $req['received_date'])->toDateTimeString();
        }
        else {
            $req['received_date'] = null;
        }

        $item->update($req);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('InputsOutputsRegisterController@edit', $id);
    }

    /**
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = InputsOutputsRegister::findOrFail($id);
        $item->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('InputsOutputsRegisterController@index');
    }

    /**
     * Multiple remove of item from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function multiple_destroy(Request $request)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $item = InputsOutputsRegister::findOrFail($id);
                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('InputsOutputsRegisterController@index');

    }

    /**
     * Upload documents files for a io item
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = InputsOutputsRegister::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('io_register/' . $id . '/documents')) {
                Storage::makeDirectory('io_register/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('io_register/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('io_register/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'io_register/' . $id . '/documents/' . $filename]);

            InputsOutputsRegisterDocument::create([
                'io_register_id' => $item->id,
                'name' => $filename,
                'file_id' => $new_file->id,
                'type' => $input['type']
            ]);

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

        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $document_id) {
                $document = InputsOutputsRegisterDocument::findOrFail($document_id);
                $file = \App\Models\File::findOrfail($document->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $document->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('InputsOutputsRegisterController@edit', $id);

    }

    /**
     * Get receivers (suppliers and customers)
     *
     * @return array|\Illuminate\Support\Collection|static
     */
    public function get_receivers()
    {
        $term = Input::get('q');

        /*
         * Suppliers
         */

        $suppliers_obj = Supplier::select('name');

        //Filters
        if ($term != '') {
            $suppliers_obj = $suppliers_obj->orWhere('name', 'LIKE', '%' . $term . '%')->orWhere('short_name', 'LIKE', '%' . $term . '%');
        }

        $suppliers = $suppliers_obj->orderBy('name')->get();


        /*
         * Customers
         */

        $customers_obj = Customer::select('name');

        //Filters
        if ($term != '') {
            $customers_obj = $customers_obj->where('name', 'LIKE', '%' . $term . '%');
        }

        $customers = $customers_obj->get();


        /*
         * Merge suppliers with customers
         */
        $receivers = $suppliers->toArray();
        $receivers = array_merge($receivers, $customers->toArray());
        $receivers = collect($receivers);
        $receivers = $receivers->sortBy('name');
        $receivers = $receivers->values()->all();

        return $receivers;
    }

    /**
     * Return projects list
     *
     * @return mixed
     */
    public function get_projects() {
        $term = Input::get('q');

        $projects_obj = new Project();

        //Filters
        if ($term != '') {
            $projects_obj = $projects_obj->where(function($query) use ($term) {
                $query->orWhere('name', 'LIKE', '%' . $term . '%');
                $query->orWhere('production_code', 'LIKE', '%' . $term . '%');
                $query->orWhere('production_no', 'LIKE', '%' . $term . '%');
            });
        }
        if (!is_null(Input::get('main_projects'))) {
            $projects_obj = $projects_obj->whereNull('parent_id');
        }

        $projects = $projects_obj->get();

        $results[] = ['name' => $term, 'id' => $term];
        foreach ($projects as &$project) {
            $result['name'] = $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name;
            $result['id'] = $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name;
            $results[] = $result;
        }

        return $results;
    }
}
