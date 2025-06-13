<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\CustomerDocument;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CustomersController extends Controller
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
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('Customers list')) {
            abort(401);
        }

        $customers_obj = Customer::where('id', '>', 0);

        //dd(Auth::user()->can('dudu'));

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $customers_obj = $customers_obj->where(function($query) use ($request) {
                $query->orWhere('name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('short_name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('vat_number', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('company_number', 'LIKE', '%' . $request->input('search') . '%');
            });

        }

        //Sort
        if ($request->has('sort')) {
            $customers_obj = $customers_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }

        $customers = $customers_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('customers._customers_list');
        }
        else {
            $view = view('customers.index');
        }

        $view = $view->with('customers', $customers);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Customers add')) {
            abort(401);
        }

        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $customer = Customer::create($request->all());

        // upload file if necessary
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $customer->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/customers/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/customers/thumbs/' . $filename), 70);

            $customer->logo = $filename;
            $customer->save();
        }

        //add contact persons
        if ($request->has('contact_name')) {
            foreach($request->input('contact_name') as $k => $contact_name) {
                if ($contact_name != '') {
                    $customer->contacts()->save(new CustomerContact([
                        'name' => $contact_name,
                        'email' => $request->input('contact_email')[$k],
                        'phone' => $request->input('contact_phone')[$k]
                    ]));
                }
            }
        }

        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        // log
        loggr(trans('log.:user a adăugat clientul :customer', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'customer' => '<a href="' . action('CustomersController@edit', $customer->id) . '" target="_blank">' . $customer->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($customer) . '", "entity_id": ' . $customer->id . '}');

        return redirect()->action('CustomersController@index');
    }

    /**
     * Display the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Customers edit')) {
            abort(401);
        }

        $customer = Customer::findOrFail($id);

        $projects = $customer->projects;

        $requests_offers_other_documents = [];
        $offers_client_other_documents = [];
        $project_contracts_documents = [];

        foreach ($projects as $project)
        {
            foreach ($project->rfq as $rfq)
            {
                $requests_offers_other_documents[] = $rfq;
            }

            foreach ($project->output_offers as $output_offers)
            {
                $offers_client_other_documents[] = $output_offers;
            }

            foreach ($project->contracts as $contracts)
            {
                $contracts->project_name = $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name;
                $project_contracts_documents[] = $contracts;
            }
        }


        return view('customers.edit')->with([
            'customer' => $customer,
            'file_type_colors' => Config::get('color.file_type_colors'),
            'contract_documents' => CustomerDocument::where('customers_id', $id)->where('type', 'contract')->get(),
            'other_documents' => CustomerDocument::where('customers_id', $id)->where('type', 'other')->get(),
            'requests_offers_other_documents' => $requests_offers_other_documents,
            'offers_client_other_documents' => $offers_client_other_documents,
            'project_contracts_documents' => $project_contracts_documents
        ]);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        // upload file if necessary
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $customer->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/customers/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/customers/thumbs/' . $filename), 70);



            $customer->logo = $filename;
            $customer->save();
        }

        //add contact persons
        if ($request->has('contact_name')) {
            $customer->contacts()->delete();
            foreach($request->input('contact_name') as $k => $contact_name) {
                if ($contact_name != '') {
                    $customer->contacts()->save(new CustomerContact([
                        'name' => $contact_name,
                        'email' => $request->input('contact_email')[$k],
                        'phone' => $request->input('contact_phone')[$k]
                    ]));
                }
            }
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat clientul :customer', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'customer' => '<a href="' . action('CustomersController@edit', $customer->id) . '" target="_blank">' . $customer->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($customer) . '", "entity_id": ' . $customer->id . '}');

        return redirect()->action('CustomersController@edit', $id);
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Delete files if has any
        if ($customer->logo && Storage::exists('/customers/' . $customer->logo)) {
            Storage::delete(['/customers/' . $customer->logo, '/customers/thumbs/' . $customer->logo]);
        }

        // delete folder
        if (Storage::exists('customers/'.$id))
        {
            Storage::deleteDirectory('customers/'.$id);
        }

        $customer->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        //log
        loggr(trans('log.:user a șters clientul :customer', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'customer' => $customer->name]), Auth::id(), '{"entity_type": "' . get_class($customer) . '", "entity_id": ' . $customer->id . '}');

        return redirect()->action('CustomersController@index');
    }

    /**
     * Multiple remove of customers from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function multiple_destroy(Request $request)
    {
        $req = $request->all();
        $names = '';
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $customer = Customer::findOrFail($id);
                $names .= $customer->name . ', ';

                // Delete files if has any
                if ($customer->logo && Storage::exists('/customers/' . $customer->logo)) {
                    Storage::delete(['/customers/' . $customer->logo, '/customers/thumbs/' . $customer->logo]);
                }

                // delete folder
                if (Storage::exists('customers/'.$id))
                {
                    Storage::deleteDirectory('customers/'.$id);
                }

                $customer->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters clientii :customer', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'customer' => $names]), Auth::id(), '{"entity_type": "' . Customer::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CustomersController@index');

    }

    /**
     * Remove the specified customer photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->logo && Storage::exists('/customers/' . $customer->logo)) {
            Storage::delete(['/customers/' . $customer->logo, '/customers/thumbs/' . $customer->logo]);
        }

        $photo_name = $customer->logo;
        $customer->logo = null;
        $customer->save();

        //log
        loggr(trans('log.:user a șters photografia :photo', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'photo' => $photo_name]), Auth::id(), '{"entity_type": "' . Customer::class . '", "entity_id": ' . $customer->id . '}');

        return redirect()->action('CustomersController@edit', $id);
    }

    /**
     * Return customers list
     *
     * @return mixed
     */
    public function get_customers() {
        $term = Input::get('q');

        $customers_obj = Customer::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $customers_obj = $customers_obj->where('name', 'LIKE', '%' . $term . '%');
        }

        $customers = $customers_obj->get();

        return $customers;
    }

    /**
     * Upload documents files for a customer
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = Customer::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('customers/' . $id . '/documents')) {
                Storage::makeDirectory('customers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('customers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('customers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'customers/' . $id . '/documents/' . $filename]);

            CustomerDocument::create([
                'customers_id' => $item->id,
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
                $document = CustomerDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . Customer::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('CustomersController@edit', $id);

    }
}
