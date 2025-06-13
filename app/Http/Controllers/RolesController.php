<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class RolesController extends Controller
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
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!hasPermission('Roles list')) {
            abort(401);
        }

        $roles_obj = Role::where('id', '>', 0);

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $roles_obj = $roles_obj->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        if ($request->has('sort')) {
            $roles_obj = $roles_obj->orderBy($request->input('sort'), $request->input('sort_direction'));

        }

        $roles = $roles_obj->orderBy('name')->paginate($this->items_per_page);

        if ($request->ajax()) {
            $view = view('roles._roles_list');
        }
        else {
            $view = view('roles.index');
        }

        $view = $view->with('roles', $roles);

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
        if (!hasPermission('Roles add')) {
            abort(401);
        }

        //permissions
        $permissions = Permission::all();
        $permission_array = array();
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $label = explode('/', $permission->label);
                $value = '';
                $array = array();
                foreach (array_reverse($label) as $k => $item) {
                    if ($k == 0) $value[$item] = ['id' => $permission->id, 'name' => $permission->name];
                    elseif ($k == 1) $array[$item] = $value;
                    else {
                        $temp = $array;
                        $array = array();
                        $array[$item] = $temp;

                    }
                }
                $permission_array = array_merge_recursive($permission_array, $array);
            }
        }

        //notification types
        $notification_types = NotificationType::all();
        $notification_types_array = array();
        if (count($notification_types) > 0) {
            foreach ($notification_types as $notification_type) {
                $label = explode('/', $notification_type->label);
                $value = '';
                $array = array();
                foreach (array_reverse($label) as $k => $item) {
                    if ($k == 0) $value[$item] = ['id' => $notification_type->id, 'name' => $notification_type->name];
                    elseif ($k == 1) $array[$item] = $value;
                    else {
                        $temp = $array;
                        $array = array();
                        $array[$item] = $temp;

                    }
                }
                $notification_types_array = array_merge_recursive($notification_types_array, $array);
            }
        }

        return view('roles.create')->with('permissions', $permission_array)->with('notification_types', $notification_types_array);
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
            'name' => 'required|max:255'
        ]);

        $role = Role::create($request->all());

        //assign permissions
        $role->permissions()->detach();
        if ($request->has('permission')) {
            $role->permissions()->attach($request->input('permission'));
        }

        //assign notifications
        $role->notification_types()->detach();
        if ($request->has('notification_type')) {
            $role->notification_types()->attach($request->input('notification_type'));
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('RolesController@index');
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
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!hasPermission('Roles edit')) {
            abort(401);
        }

        $role = Role::findOrFail($id);

        //permissions
        $permissions = Permission::all();
        $permission_array = array();
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $label = explode('/', $permission->label);
                $value = '';
                $array = array();
                foreach (array_reverse($label) as $k => $item) {
                    if ($k == 0) $value[$item] = ['id' => $permission->id, 'name' => $permission->name];
                    elseif ($k == 1) $array[$item] = $value;
                    else {
                        $temp = $array;
                        $array = array();
                        $array[$item] = $temp;

                    }
                }
                $permission_array = array_merge_recursive($permission_array, $array);
            }
        }

        //notification types
        $notification_types = NotificationType::all();
        $notification_types_array = array();
        if (count($notification_types) > 0) {
            foreach ($notification_types as $notification_type) {
                $label = explode('/', $notification_type->label);
                $value = '';
                $array = array();
                foreach (array_reverse($label) as $k => $item) {
                    if ($k == 0) $value[$item] = ['id' => $notification_type->id, 'name' => $notification_type->name];
                    elseif ($k == 1) $array[$item] = $value;
                    else {
                        $temp = $array;
                        $array = array();
                        $array[$item] = $temp;

                    }
                }
                $notification_types_array = array_merge_recursive($notification_types_array, $array);
            }
        }


        return view('roles.edit')->with('role', $role)->with('permissions', $permission_array)->with('notification_types', $notification_types_array);
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
            'name' => 'required|max:255'
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        //assign permissions
        $role->permissions()->detach();
        if ($request->has('permission')) {
            $role->permissions()->attach($request->input('permission'));
        }

        //assign notifications
        $role->notification_types()->detach();
        if ($request->has('notification_type')) {
            $role->notification_types()->attach($request->input('notification_type'));
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('RolesController@edit', $id);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('RolesController@index');
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
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $id) {
                $role = Role::findOrFail($id);
                $role->permissions()->detach();
                $role->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('RolesController@index');

    }
}
