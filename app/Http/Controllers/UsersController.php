<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Participant;
use App\Models\UserDocument;
use App\Models\MeasuringEquipment;
use App\Models\Ruler;
use App\Models\Education;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class UsersController extends Controller
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
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('Users list')) {
            abort(401);
        }

        $users_obj = User::where('id', '>', 0);

        //Filters
        if ($request->has('name') && $request->input('name') != '') {
            $users_obj = $users_obj->where(function($query) use ($request) {
                $query->orWhere('lastname', 'LIKE', '%' . $request->input('name') . '%');
                $query->orWhere('firstname', 'LIKE', '%' . $request->input('name') . '%');
            });

        }
        if ($request->has('role') && $request->input('role') !='' && $request->input('role') !='0') {
            $users_obj = $users_obj->whereHas('roles', function ($query) use ($request) {
                $query->where('role_id', $request->input('role'));
            });
        }
        if ($request->has('status') && $request->input('status') != '' && $request->input('status') != '0')
        {
            $users_obj = $users_obj->where('status', $request->input('status'));
        }

        //Sort
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'name':
                    $users_obj = $users_obj->orderBy('lastname', $request->input('sort_direction'))->orderBy('firstname', $request->input('sort_direction'));
                    break;
                default:
                    $users_obj = $users_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }
        }

        $users = $users_obj->paginate($this->items_per_page);

        /*foreach (User::all() as $user) {
            //$user->assignRole(rand(1, 11));
        }*/

        if ($request->ajax()) {
            $view = view('users._users_list');
        }
        else {
            $view = view('users.index');
        }

        $view = $view->with('users', $users)->with('roles', Role::all())->with('role_colors', Config::get('color.user_roles_colors'))->with('colors', Config::get('color.user_colors'));

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!hasPermission('Users add')) {
            abort(401);
        }

        return view('users.create')->with('roles', Role::all());
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'regex:/^([0-9\+\)\( ]*)$/',
            'personal_phone' => 'regex:/^([0-9\+\)\( ]*)$/',
            'role' => 'required'
        ]);

        $req = $request->all();
        $req['password'] = bcrypt($req['password']);
        $req['remember_token'] = str_random(10);
        if ($req['dob'] != '') {
            $req['dob'] = Carbon::createFromFormat('d-m-Y', $req['dob'])->toDateTimeString();
        }
        else {
            $req['dob'] = null;
        }

        if ($req['status'] == 0)
        {
            $req['status'] = 'active';
        }
        else
        {
            $req['status'] = 'inactive';
        }


        $user = User::create($req);

        // upload file if necessary
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $user->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/users/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/users/thumbs/' . $filename), 70);

            $user->photo = $filename;
            $user->save();
        }

        //assign roles
        if ($request->has('role') && count($request->input('role')) > 0) {
            foreach($request->input('role') as $role) {
                $user->assignRole($role);
            }
        }

        //create basics education
        foreach (Config::get('education.basics_educations') as $item) {
            $item['nr'] = $user->id . $item['nr'];
            $education = Education::create($item);
            Participant::create(['education_id' => $education->id, 'user_id' => $user->id]);

            // log
            loggr(trans('log.:user a adăugat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $education->id . '}');
        }


        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        // log
        loggr(trans('log.:user a adăugat utilizatorul :users', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'users' => '<a href="' . action('UsersController@edit', $user->id) . '" target="_blank">' . $user->name() . '</a>']), Auth::id(), '{"entity_type": "' . get_class($user) . '", "entity_id": ' . $user->id . '}');

        return redirect()->action('UsersController@index');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Users edit')) {
            abort(401);
        }

        $user = User::findOrFail($id);
        $rulers = Ruler::where('user_id', $id)->get();
        $equipments = MeasuringEquipment::where('user_id', $id)->get();
        $participant = Participant::where('user_id', $id)->get();
        $diploma = UserDocument::where('users_id', $id)->where('type', 'diploma')->get();

        $i = 0;
        $trainer = Education::query();
        foreach ($user->roles as $role) {
            $trainer = $trainer->orWhere('role_id', $role->id);
            $i++;
        }

        if ($i > 0) {
            $trainer = $trainer->get();
        }
        else {
            $trainer = null;
        }

        return view('users.edit')->with([
            'user' => $user,
            'roles' => Role::all(),
            'file_type_colors' => Config::get('color.file_type_colors'),
            'rulers' => $rulers,
            'equipments' => $equipments,
            'identity_documents' => UserDocument::where('users_id', $id)->where('type', 'identity')->get(),
            'diploma_documents' => UserDocument::where('users_id', $id)->where('type', 'diploma')->get(),
            'family_documents' => UserDocument::where('users_id', $id)->where('type', 'family')->get(),
            'employment_contract_documents' => UserDocument::where('users_id', $id)->where('type', 'employment_contract')->get(),
            'job_description_documents' => UserDocument::where('users_id', $id)->where('type', 'job_description')->get(),
            'decision_documents' => UserDocument::where('users_id', $id)->where('type', 'decision')->get(),
            'medical_record_documents' => UserDocument::where('users_id', $id)->where('type', 'medical_record')->get(),
            'participant' => $participant,
            'diploma' => $diploma,
            'trainer' => $trainer
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'password' => 'confirmed|min:6',
            'phone' => 'regex:/^([0-9\+\)\( ]*)$/',
            'personal_phone' => 'regex:/^([0-9\+\)\( ]*)$/',
            'role' => 'required'
        ]);


        $req = $request->all();
        $ruler = Ruler::where('user_id', $id)->get();
        $measuring = MeasuringEquipment::where('user_id', $id)->get();

        if ($req['password'] == '') {
            unset($req['password']);
        }
        else {
            $req['password'] = bcrypt($req['password']);
        }

        if ($req['dob'] != '') {
            $req['dob'] = Carbon::createFromFormat('d-m-Y', $req['dob'])->toDateTimeString();
        }
        else {
            $req['dob'] = null;
        }

        if ($req['status'] == 0)
        {
            $req['status'] = 'active';
        }
        else
        {
            if (count($ruler) == 0 && count($measuring) == 0)
            {
                $req['status'] = 'inactive';
            }
        }

        $user = User::findOrFail($id);
        $user->update($req);

        // upload file if necessary
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file = File::get($file);
            $filename = alphaID() . '_id_' . $user->id . '.' . $extension;

            // save original
            Image::make($file)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/users/' . $filename));

            // generate and save thumb
            Image::make($file)->fit(150, 150)->save(storage_path('app/users/thumbs/' . $filename), 70);



            $user->photo = $filename;
            $user->save();
        }

        //assign roles
        if ($request->has('role') && count($request->input('role')) > 0) {
            $user->roles()->detach();
            foreach($request->input('role') as $role) {
                $user->assignRole($role);
            }
        }

        if ((count($ruler) > 0 || count($measuring) > 0) && $req['status'] == '1')
        {
            Session::flash('error_msg', trans('Angajatul nu poate fi dezactivat, pentru că posedă echipamente de măsurare'));
        }
        else
        {
            Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));
        }

        // log
        loggr(trans('log.:user a editat utilizatorul :users', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'users' => '<a href="' . action('UsersController@edit', $user->id) . '" target="_blank">' . $user->name() . '</a>']), Auth::id(), '{"entity_type": "' . get_class($user) . '", "entity_id": ' . $user->id . '}');

        return redirect()->action('UsersController@edit', $id);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete files if has any
        if ($user->photo && Storage::exists('/users/' . $user->photo)) {
            Storage::delete(['/users/' . $user->photo, '/users/thumbs/' . $user->photo]);
        }

        // delete folder
        if (Storage::exists('users/'.$id))
        {
            Storage::deleteDirectory('users/'.$id);
        }

        $user->roles()->detach();
        $user->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        //log
        loggr(trans('log.:user a șters utilizatorul :users', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'users' => $user->name]), Auth::id(), '{"entity_type": "' . get_class($user) . '", "entity_id": ' . $user->id . '}');

        return redirect()->action('UsersController@index');
    }

    /**
     * Multiple remove of users from storage.
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
                $user = User::findOrFail($id);
                $names .= $user->name() . ', ';

                // Delete files if has any
                if ($user->photo && Storage::exists('/users/' . $user->photo)) {
                    Storage::delete(['/users/' . $user->photo, '/users/thumbs/' . $user->photo]);
                }

                // delete folder
                if (Storage::exists('users/'.$id))
                {
                    Storage::deleteDirectory('users/'.$id);
                }

                $user->roles()->detach();
                $user->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a șters utilizatorii :users', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'users' => $names]), Auth::id(), '{"entity_type": "' . User::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('UsersController@index');

    }

    /**
     * Remove the specified user photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_photo($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && Storage::exists('/users/' . $user->photo)) {
            Storage::delete(['/users/' . $user->photo, '/users/thumbs/' . $user->photo]);
        }

        $photo_name = $user->photo;
        $user->photo = null;
        $user->save();

        //log
        loggr(trans('log.:user a șters photografia :photo', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'photo' => $photo_name]), Auth::id(), '{"entity_type": "' . User::class . '", "entity_id": ' . $user->id . '}');

        return redirect()->action('UsersController@edit', $id);
    }

    /**
     * Return users list
     *
     * @return mixed
     */
    public function get_users() {
        $term = Input::get('q');

        $users_obj = User::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $users_obj = $users_obj->where(function($query) use ($term) {
                $query->orWhere('lastname', 'LIKE', '%' . $term . '%');
                $query->orWhere('firstname', 'LIKE', '%' . $term . '%');
            });
        }

        $users = $users_obj->get();

        foreach ($users as &$user) {
            $user->name = $user->firstname . ' ' . $user->lastname;
        }

        return $users;
    }

    /**
     * Upload documents files for a user
     *
     * @param $id
     * @return string
     */
    public function documents_upload($id)
    {
        $item = User::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('users/' . $id . '/documents')) {
                Storage::makeDirectory('users/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('users/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('users/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'users/' . $id . '/documents/' . $filename]);

            UserDocument::create([
                'users_id' => $item->id,
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
                $document = UserDocument::findOrFail($document_id);
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
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . User::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('UsersController@edit', $id);

    }

    public function deactivation(Request $request)
    {
        $req = $request->all();
        $names = '';
        $ids = [];
        if (count($req['remove']) > 0)
        {
            $error_users = '';

            foreach ($req['remove'] as $id)
            {
                $user = User::findOrFail($id);
                $ruler = Ruler::where('user_id', $id)->get();
                $measuring = MeasuringEquipment::where('user_id', $id)->get();

                if (count($ruler) > 0 || count($measuring) > 0)
                {
                    $error_users = $error_users . ', ' . $user->name();
                }
                else
                {
                    $ids[] = $id;
                    $names .= $user->name() . ', ';
                    $user->status = 'inactive';
                    $user->save();
                }
            }

            $error_users = preg_replace('/^,\s/', '', $error_users);

            if ($error_users != '')
            {
                Session::flash('error_msg', trans('Angajaturii: ' . $error_users . ' nu poate fi dezactivat, pentru că posedă echipamente de măsurare'));
            }
            else
            {
                Session::flash('success_msg', trans('Înregistrările au fost dezactivat cu succes'));
            }

            $names = preg_replace('/,\s$/', '', $names);

            //log
            loggr(trans('log.:user a deactivat utilizatorii :users', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'users' => $names]), Auth::id(), '{"entity_type": "' . User::class . '", "entity_id": ' . json_encode($ids) . '}');
        }

        return redirect()->action('UsersController@index');
    }

    public function confirmed($id)
    {
        $participant = Participant::where('education_id', $id)->where('user_id', Auth::user()->id)->first();

        $education = Education::findOrFail($id);

        $participant->user_confirmed = true;
        $participant->save();

        // log
        loggr(trans('log.:user a confirmat instruirea :education', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'education' => $education->nr]), Auth::id(), '{"entity_type": "' . get_class($education) . '", "entity_id": ' . $id . '}');

        Session::flash('success_msg', trans('Instruirea a fost confirmat'));

        return redirect()->action('UsersController@edit', Auth::user()->id);
    }
}
