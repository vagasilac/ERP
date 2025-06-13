<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\SupplierContact;
use App\Models\SupplierDocument;
use App\Models\SupplierRating;
use App\Models\SupplierRatingOption;
use App\Models\SupplierType;
use App\Models\SupplierToType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SuppliersController extends Controller
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
     * Display a listing of the suppliers.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $type
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function index(Request $request, $type = null)
    {
        if (!hasPermission('Suppliers list')) {
            abort(401);
        }

        $suppliers_obj = Supplier::where('id', '>', 0);
        $types = SupplierType::all();

       if (!is_null($type)) {
           $suppliers_obj = SupplierToType::where('type_id', $type);
           $suppliers_obj = $suppliers_obj->join('suppliers', 'supplier_to_types.supplier_id', '=', 'suppliers.id')
               ->select('suppliers.*', 'supplier_to_types.type_id');
       }

        //dd(Auth::user()->can('dudu'));

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $suppliers_obj = $suppliers_obj->where(function($query) use ($request) {
                $query->orWhere('name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('short_name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('vat_number', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('company_number', 'LIKE', '%' . $request->input('search') . '%');
            });
        }



        //Sort
        if ($request->has('sort')) {
            $suppliers_obj = $suppliers_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
        }
        else {
            $suppliers_obj = $suppliers_obj->orderBy('average_rating', $request->input('DESC'));
        }
        $suppliers = $suppliers_obj->paginate($this->items_per_page);
        if ($request->ajax()) {
            $view = view('suppliers._suppliers_list');
        }
        else {
            $view = view('suppliers.index');
        }


        $view = $view->with(['suppliers' => $suppliers, 'types' => $types]);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new supplier.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Suppliers add')) {
            abort(401);
        }

        $types = SupplierType::all();

        return view('suppliers.create')->with('types', $types);
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'required'
        ]);

        $supplier = Supplier::create($request->all());

        // upload file if necessary
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $supplier->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/suppliers/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/suppliers/thumbs/' . $filename), 70);

            $supplier->logo = $filename;
            $supplier->save();
        }

        //add contact persons
        if ($request->has('contact_name')) {
            foreach($request->input('contact_name') as $k => $contact_name) {
                if ($contact_name != '') {
                    $supplier->contacts()->save(new SupplierContact([
                        'name' => $contact_name,
                        'email' => $request->input('contact_email')[$k],
                        'phone' => $request->input('contact_phone')[$k]
                    ]));
                }
            }
        }

        //add additional addresses
        if ($request->has('additional_address')) {
            foreach($request->input('additional_address') as $k => $address) {
                if ($address != '') {
                    $supplier->contacts()->save(new SupplierAddress([
                        'address' => $address,
                        'city' => $request->input('additional_city')[$k],
                        'county' => $request->input('additional_county')[$k],
                        'country' => $request->input('additional_country')[$k]
                    ]));
                }
            }
        }

        //assign type
        if ($request->has('type') && count($request->input('type')) > 0)
        {
            foreach ($request->input('type') as $type)
            {
                SupplierToType::create([
                    'supplier_id' => $supplier->id,
                    'type_id' => $type
                ]);
            }
        }

        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        // log
        loggr(trans('log.:user a adăugat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');

        return redirect()->action('SuppliersController@index');
    }

    /**
     * Display the specified supplier.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified supplier.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Suppliers edit')) {
            abort(401);
        }

        $supplier = Supplier::findOrFail($id);

        // ratings by options
        $supplier_ratings = [];
        foreach ($supplier->ratings as $rating) {
            foreach ($rating->options as $option) {
                $supplier_ratings[$option->id][] = $option->pivot->value;
            }
        }
        foreach ($supplier_ratings as $k => $ratings) {
            $supplier_ratings[$k] = round(array_sum($supplier_ratings[$k]) / count($supplier_ratings[$k]), 2);
        }


        return view('suppliers.edit')->with([

            'contract_documents' => SupplierDocument::where('suppliers_id', $id)->where('type', 'contract')->get(),
            'documents' => SupplierDocument::where('suppliers_id', $id)->get(),
            'file_type_colors' => Config::get('color.file_type_colors'),
            'other_documents' => SupplierDocument::where('suppliers_id', $id)->where('type', 'other')->get(),
            'rating_options' => SupplierRatingOption::all(),
            'supplier' => $supplier,
            'supplier_ratings' => $supplier_ratings,
            'types' => SupplierType::all()
        ]);
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'required'
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        // upload file if necessary
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $supplier->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/suppliers/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/suppliers/thumbs/' . $filename), 70);



            $supplier->logo = $filename;
            $supplier->save();
        }

        //add contact persons
        if ($request->has('contact_name')) {
            $supplier->contacts()->delete();
            foreach($request->input('contact_name') as $k => $contact_name) {
                if ($contact_name != '') {
                    $supplier->contacts()->save(new SupplierContact([
                        'name' => $contact_name,
                        'email' => $request->input('contact_email')[$k],
                        'phone' => $request->input('contact_phone')[$k]
                    ]));
                }
            }
        }

        //add additional addresses
        if ($request->has('additional_address')) {
            $supplier->addresses()->delete();
            foreach($request->input('additional_address') as $k => $address) {
                if ($address != '') {
                    $supplier->addresses()->save(new SupplierAddress([
                        'address' => $address,
                        'city' => $request->input('additional_city')[$k],
                        'county' => $request->input('additional_county')[$k],
                        'country' => $request->input('additional_country')[$k]
                    ]));
                }
            }
        }

        //add type
        if ($request->has('type') && count($request->input('type')) > 0)
        {
            $items = $supplier->types;
            foreach ($items as $item)
            {
                $item->delete();
            }

            foreach ($request->input('type') as $type)
            {
                SupplierToType::create([
                    'supplier_id' => $supplier->id,
                    'type_id' => $type
                ]);
            }
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');

        return redirect()->action('SuppliersController@edit', $id);
    }

    /**
     * Remove the specified supplier from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Delete files if has any
        if ($supplier->logo && Storage::exists('/suppliers/' . $supplier->logo)) {
            Storage::delete(['/suppliers/' . $supplier->logo, '/suppliers/thumbs/' . $supplier->logo]);
        }

        // delete folder
        if (Storage::exists('suppliers/'.$id))
        {
            Storage::deleteDirectory('suppliers/'.$id);
        }

        $supplier->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        //log
        loggr(trans('log.:user a șters furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => $supplier->name]), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');

        return redirect()->action('SuppliersController@index');
    }

    /**
     * Multiple remove of suppliers from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function multiple_destroy(Request $request)
    {
        $req = $request->all();
        $names = '';
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $supplier = Supplier::findOrFail($id);

                $names .= $supplier->name . ', ';

                // Delete files if has any
                if ($supplier->logo && Storage::exists('/suppliers/' . $supplier->logo)) {
                    Storage::delete(['/suppliers/' . $supplier->logo, '/suppliers/thumbs/' . $supplier->logo]);
                }

                // delete folder
                if (Storage::exists('suppliers/'.$id))
                {
                    Storage::deleteDirectory('suppliers/'.$id);
                }

                $supplier->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters furnizorii :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => $names]), Auth::id(), '{"entity_type": "' . Supplier::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('SuppliersController@index');

    }

    /**
     * Remove the specified supplier photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->logo && Storage::exists('/suppliers/' . $supplier->logo)) {
            Storage::delete(['/suppliers/' . $supplier->logo, '/suppliers/thumbs/' . $supplier->logo]);
        }

        $photo_name = $supplier->logo;
        $supplier->logo = null;
        $supplier->save();

        //log
        loggr(trans('log.:user a șters photografia :photo', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'photo' => $photo_name]), Auth::id(), '{"entity_type": "' . Supplier::class . '", "entity_id": ' . $supplier->id . '}');

        return redirect()->action('SuppliersController@edit', $id);
    }


    /**
     * Return suppliers list
     *
     * @return mixed
     */
    public function get_suppliers() {
        $term = Input::get('q');

        $suppliers_obj = new Supplier();

        //Filters
        if ($term != '') {
            $suppliers_obj = $suppliers_obj->orWhere('name', 'LIKE', '%' . $term . '%')->orWhere('short_name', 'LIKE', '%' . $term . '%');
        }

        $suppliers = $suppliers_obj->orderBy('name')->get();

        if (count($suppliers) > 0) {
            foreach ($suppliers as &$supplier) {
                $supplier->long_name = $supplier->name . ($supplier->short_name != '' ? ' (' . $supplier->short_name . ')' : '');
            }
        }


        return $suppliers;
    }

    /**
     * Upload documents files for a supplier
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = Supplier::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('suppliers/' . $id . '/documents')) {
                Storage::makeDirectory('suppliers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('suppliers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('suppliers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'suppliers/' . $id . '/documents/' . $filename]);

            SupplierDocument::create([
                'suppliers_id' => $item->id,
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
                $document = SupplierDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . Supplier::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('SuppliersController@edit', $id);

    }


    /**
     * Rate a supplier
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rating(Request $request, $id)
    {
        if ($request->has('rating')) {
            $rating = SupplierRating::create([
                'supplier_id' => $id,
                'user_id' => Auth::id(),
                'order_number' => $request->get('order_number')
            ]);

            foreach ($request->get('rating') as $option_id => $value) {
                if ($value != '') {
                    $rating->options()->save(SupplierRatingOption::find($option_id), ['value' => $value]);
                }
            }


            // update supplier's average rating
            $supplier = Supplier::find($id);
            $average_rating = 0.0;
            $no_of_ratings = 0;
            /*foreach ($supplier->ratings as $rating) {
                foreach ($rating->options as $option) {
                    $average_rating = $average_rating + $option->pivot->value;
                    $no_of_ratings++;
                }
            }*/
            $supplier_ratings = [];
            foreach ($supplier->ratings as $rating) {
                foreach ($rating->options as $option) {
                    $supplier_ratings[$option->id][] = $option->pivot->value;
                }
            }
            foreach ($supplier_ratings as $k => $ratings) {
                $average_rating = $average_rating + round(array_sum($supplier_ratings[$k]) / count($supplier_ratings[$k]), 2);
                $no_of_ratings++;

            }
            $supplier->average_rating = round($average_rating / $no_of_ratings, 2);
            $supplier->save();

            Session::flash('success_msg', trans('Evaluarea a fost salvată cu succes'));

            // log
            loggr(trans('log.:user a evaluat furnizorul :supplier', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'supplier' => '<a href="' . action('SuppliersController@edit', $supplier->id) . '" target="_blank">' . $supplier->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($supplier) . '", "entity_id": ' . $supplier->id . '}');
        }

        return redirect()->action('SuppliersController@edit', [$id, '#rating']);

    }
}
