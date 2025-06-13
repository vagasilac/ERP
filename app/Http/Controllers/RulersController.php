<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ruler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\RulersDocument;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class RulersController extends Controller
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
     * Display a listing of the IO items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('Rulers list')) {
            abort(401);
        }

        $me_obj = Ruler::query();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $me_obj = $me_obj->where('name', 'LIKE', '%' . $request->input('search') . '%');
            $me_obj = $me_obj->orWhere('inventory_number', 'LIKE', '%' . $request->input('search') . '%');
            $me_obj = $me_obj->orWhere('measuring_range', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'user') {
                $me_obj = $me_obj->join('users', 'rulers.user_id', '=', 'users.id');
                $me_obj = $me_obj->orderBy('users.firstname', $request->input('sort_direction'))->orderBy('users.lastname', $request->input('sort_direction'));
            }
            else {
                $me_obj = $me_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }

        }
        else {
            $me_obj->orderBy('inventory_number', 'DESC');
        }

        $items = $me_obj->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('rulers._ru_list');
        }
        else {
            $view = view('rulers.index');
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
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Rulers add')) {
            abort(401);
        }

        return view('rulers.create');
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'inventory_number' => 'required'
        ]);

        $req = $request->all();

        $item = Ruler::create($req);

        // upload photo
        if ($request->file('photo') != null)
        {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = alphaID() . '.' . $extension;

            // generate photos directory
            if (!Storage::exists('ims/rulers/' . $item->id . '/photos'))
            {
                Storage::makeDirectory('ims/rulers/' . $item->id . '/photos');
            }

            // generate thumbnails directory
            if (!Storage::exists('ims/rulers/' . $item->id . '/photos/thumbnails'))
            {
                Storage::makeDirectory('ims/rulers/' . $item->id . '/photos/thumbnails');
            }


            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/ims/rulers/' . $item->id . '/photos/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/ims/rulers/' . $item->id . '/photos/thumbnails/' . $filename), 70);


            $item->photo = $filename;
            $item->save();
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a adăugat ruletă :rulers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'rulers' => '<a href="' . action('RulersController@edit', $item->id) . '" target="_blank">' . $item->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('RulersController@edit', $item->id);
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Rulers add')) {
            abort(401);
        }

        $item = Ruler::findOrFail($id);

        return view('rulers.edit')->with([
            'file_type_colors' => Config::get('color.file_type_colors'),
            'item' => $item,
            'documents' => RulersDocument::where('rulers_id', $id)->get()
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
            'name' => 'required',
            'inventory_number' => 'required'
        ]);

        $item = Ruler::findOrFail($id);

        $req = $request->all();

        if ($req['user_id'] == '')
        {
            $req['user_id'] = $item->user_id;
        }

        $item->update($req);

        if ($request->file('photo') != null)
        {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = alphaID() . '.' . $extension;

            // generate photos directory
            if (!Storage::exists('ims/rulers/' . $item->id . '/photos'))
            {
                Storage::makeDirectory('ims/rulers/' . $item->id . '/photos');
            }

            // generate thumbnails directory
            if (!Storage::exists('ims/rulers/' . $item->id . '/photos/thumbnails'))
            {
                Storage::makeDirectory('ims/rulers/' . $item->id . '/photos/thumbnails');
            }


            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/ims/rulers/' . $item->id . '/photos/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/ims/rulers/' . $item->id . '/photos/thumbnails/' . $filename), 70);

            $item->photo = $filename;
            $item->save();
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        // log
        loggr(trans('log.:user a editat ruletă :rulers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'rulers' => '<a href="' . action('RulersController@edit', $item->id) . '" target="_blank">' . $item->name . '</a>']), Auth::id(), '{"entity_type": "' . get_class($item) . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('RulersController@edit', $id);
    }

    /**
     * Multiple remove of roles from storage.
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
                $item = Ruler::findOrFail($id);

                $names .= $item->name . ', ';

                // delete folder
                if (Storage::exists('ims/rulers/'.$id))
                {
                    Storage::deleteDirectory('ims/rulers/'.$id);
                }

                $item->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters rulete :rulers', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'rulers' => $names]), Auth::id(), '{"entity_type": "' . Ruler::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('RulersController@index');

    }

    /**
     * Remove the specified user photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo($id)
    {
        $item = Ruler::findOrFail($id);

        if ($item->photo && Storage::exists('ims/rulers/'.$id.'/photos/'.$item->photo) && Storage::exists('ims/rulers/'.$id.'/photos/thumbnails/'.$item->photo))
        {
            Storage::delete('ims/rulers/'.$id.'/photos/'.$item->photo);
            Storage::delete('ims/rulers/'.$id.'/photos/thumbnails/'.$item->photo);
        }

        $photo_name = $item->photo;
        $item->photo = null;
        $item->save();

        //log
        loggr(trans('log.:user a șters photografia :photo', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'photo' => $photo_name]), Auth::id(), '{"entity_type": "' . Ruler::class . '", "entity_id": ' . $item->id . '}');

        return redirect()->action('RulersController@edit', $id);
    }

    /**
     * Upload documents files for a project
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = Ruler::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('ims/rulers/' . $id . '/documents')) {
                Storage::makeDirectory('ims/rulers/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('ims/rulers/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('ims/rulers/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'ims/rulers/' . $id . '/documents/' . $filename]);

            RulersDocument::create([
                'rulers_id' => $item->id,
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
                $document = RulersDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . Ruler::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('RulersController@edit', $id);

    }
}
