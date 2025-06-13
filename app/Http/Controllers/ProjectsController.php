<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Customer;
use App\Models\GanttTask;
use App\Models\NotificationType;
use App\Models\Project;
use App\Models\ProjectCalculation;
use App\Models\ProjectContract;
use App\Models\ProjectControlPlan;
use App\Models\ProjectControlPlanCategory;
use App\Models\ProjectControlPlanItem;
use App\Models\ProjectCutting;
use App\Models\ProjectDatasheet;
use App\Models\ProjectDocument;
use App\Models\ProjectDocumentCategory;
use App\Models\ProjectDrawing;
use App\Models\ProjectDrawingsRegister;
use App\Models\ProjectFolder;
use App\Models\ProjectFoldersStatus;
use App\Models\ProjectInvoice;
use App\Models\ProjectMail;
use App\Models\ProjectMaterial;
use App\Models\ProjectOutputOffer;
use App\Models\ProjectPhoto;
use App\Models\ProjectQualityControlDrawing;
use App\Models\ProjectRequirementsAnalysis;
use App\Models\ProjectRequirementsAnalysisItem;
use App\Models\ProjectRFQ;
use App\Models\ProjectSubassembly;
use App\Models\ProjectSubassemblyGroup;
use App\Models\ProjectSubassemblyGroupResponsible;
use App\Models\ProjectSubassemblyPart;
use App\Models\ProjectTimeTracking;
use App\Models\ProjectTransport;
use App\Models\ProjectOrderConfirmation;
use App\Models\Role;
use App\Models\SettingsMaterial;
use App\Models\SettingsStandard;
use App\Models\User;
use App\Models\ProjectOffer;
use Barryvdh\DomPDF\PDF;
use C4studio\Notification\Facades\Notification;
use Carbon\Carbon;
use DVDoug\BoxPacker\Packer;
use DVDoug\BoxPacker\TestBox;
use DVDoug\BoxPacker\TestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsController extends Controller
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
     * Display a listing of the projects.
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        if (!hasPermission('Projects - Projects list')) {
            abort(401);
        }

        $projects_obj = Project::select('projects.*');
        $projects_obj->whereNull('parent_id');

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $projects_obj = $projects_obj->where(function($query) use ($request) {
                $query->orWhere('name', 'LIKE', '%' . $request->input('search') . '%')->orWhereHas('children', function ($query) use ($request) {
                    $query->orWhere('name', 'LIKE', '%' . $request->input('search') . '%');
                });
            });

        }
        if ($request->has('customer') && $request->input('customer') !='') {
            $projects_obj = $projects_obj->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('customer') . '%');
            });
        }
        if ($request->has('created_date') && $request->input('created_date') !='') {
            $date = explode('-', $request->input('created_date'));
            if (count($date) > 1) {
                $projects_obj = $projects_obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[0]))))->where('created_at', '<=', date('Y-m-d 00:00:00', strtotime(str_replace('/','-',$date[1]))));
            }

        }
        if ($request->has('user') && $request->input('user') !='') {
            $projects_obj = $projects_obj->where(function ($query) use ($request) {
                $query->where('primary_responsible', $request->input('user'))->whereOr('secondary_responsible', $request->input('user'));
            });
        }
        if ($request->has('type') && $request->input('type') !='') {
            $projects_obj = $projects_obj->where('type', $request->input('type'));
        }

        //Sort
        if ($request->has('sort')) {
            if ($request->input('sort') == 'customer') {
                $projects_obj = $projects_obj->join('customers', 'projects.customer_id', '=', 'customers.id');
                $projects_obj = $projects_obj->orderBy('customers.name', $request->input('sort_direction'));
            }
            if ($request->input('sort') == 'responsible') {
                $projects_obj = $projects_obj->join('users', 'projects.primary_responsible', '=', 'users.id');
                $projects_obj = $projects_obj->orderBy('users.firstname', $request->input('sort_direction'));
            }
            elseif ($request->input('sort') == 'type') {
                $projects_obj = $projects_obj->orderBy('primary_code', $request->input('sort_direction'))->orderBy('secondary_code', $request->input('sort_direction'));
            }
            elseif ($request->input('sort') == 'code') {
                $projects_obj = $projects_obj->orderBy('production_no', $request->input('sort_direction'))->orderBy('production_code', $request->input('sort_direction'));
            }
            elseif ($request->input('sort') == 'name') {
                $projects_obj = $projects_obj->orderBy('name', $request->input('sort_direction'));
            }
            else {
                $projects_obj = $projects_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }
        }
        else {
            $projects_obj = $projects_obj->orderBy('created_at', 'DESC');
        }

        $projects = $projects_obj->paginate($this->items_per_page);

        $projects_with_children = collect([]);

        foreach ($projects as $project) {
            $projects_with_children->push($project);

            if (count($project->children) > 0) {
                foreach ($project->children as $child) {
                    $projects_with_children->push($child);
                }
            }

            // get deadlines
            $project->deadlines = [];
            if (!is_null($project->datasheet)) {
                $dates = $project->datasheet->data->deadlines->date;
                usort($dates, 'date_compare');
                $project->deadlines = $dates;
            }
        }

        if ($request->ajax()) {
            $view = view('projects._projects_list');
        }
        else {
            $view = view('projects.index');
        }

        $view = $view->with(['projects' => $projects, 'projects_with_children' => $projects_with_children, 'status_colors' => Config::get('color.project_status_colors')])->with('primary_codes', Config::get('settings.primary_codes'))->with('secondary_codes', Config::get('settings.secondary_codes'))->with('colors', Config::get('color.user_colors'));

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        if (!hasPermission('Projects - Projects add')) {
            abort(401);
        }

        return view('projects.create')->with('next_production_no', Project::max('production_no') + 1)->with('primary_codes', Config::get('settings.primary_codes'))->with('secondary_codes', Config::get('settings.secondary_codes'))->with('parent', Project::find($id));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'customer' => 'required',
            'primary_responsible_id' => 'required'
        ]);


        $project_data = $request->all();
        $customer = Customer::firstOrCreate(['name' => $project_data['customer']]);
        $project_data['customer_id'] = $customer->id;
        $project_data['primary_responsible'] = $project_data['primary_responsible_id'] != '' ? $project_data['primary_responsible_id'] : null;
        $project_data['secondary_responsible'] = $project_data['secondary_responsible_id'] == '' ? null : $project_data['secondary_responsible_id'];
        if ($project_data['deadline'] != '') {
            $project_data['deadline'] = Carbon::createFromFormat('d-m-Y', $project_data['deadline'])->toDateTimeString();
        }
        else {
            $project_data['deadline'] = null;
        }

        if ($project_data['type'] != 'offer') {
            $project_data['production_no'] = Project::max('production_no') + 1;
        }

        if ($project_data['parent_id'] == '') $project_data['parent_id'] = null;

        $project = Project::create($project_data);

        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        //Notification
        NotificationType::send('Projects - Add new project', trans('notifications.<b>:user</b> a creat un proiect nou: <b>:project</b>', ['user' => Auth::user()->name(), 'project' => $project->production_name() . ' '. $project->customer->short_name . ' ' . $project->name]), action('ProjectsController@general_info', $project->id));

        return redirect()->action('ProjectsController@index');

    }

    /**
     * Remove the specified project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('ProjectsController@index');
    }

    /**
     * Multiple remove of projects from storage.
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
                $project = Project::findOrFail($id);

                $project->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@index');

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

        foreach ($projects as &$project) {
            $project->name = $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name;
        }

        return $projects;
    }

    /**
     * Show the form for editing the general info of the specified supplier.
     *
     * @param $id
     * @return $this
     */
    public function general_info($id)
    {
        if (!hasPermission('Projects - Edit general info')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.general')->with('project', $project)->with('next_production_no', Project::max('production_no') + 1)->with('primary_codes', Config::get('settings.primary_codes'))->with('secondary_codes', Config::get('settings.secondary_codes'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function general_info_update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255',
            'customer_id' => 'required',
            'primary_responsible_id' => 'required'
        ]);

        $project_data = $request->all();
        $customer = Customer::firstOrCreate(['name' => $project_data['customer']]);
        $project_data['customer_id'] = $customer->id;
        $project_data['primary_responsible'] = $project_data['primary_responsible_id'] != '' ? $project_data['primary_responsible_id'] : null;
        $project_data['secondary_responsible'] = $project_data['secondary_responsible_id'] != '' ? $project_data['secondary_responsible_id'] : null;
        if ($project_data['deadline'] != '') {
            $project_data['deadline'] = Carbon::createFromFormat('d-m-Y', $project_data['deadline'])->toDateTimeString();
        }
        else {
            $project_data['deadline'] = null;
        }
        if ($project_data['type'] != 'offer' && $project->type == 'offer') {
            $project_data['production_no'] = Project::max('production_no') + 1;
        }
        if ($project_data['parent_id'] == '') $project_data['parent_id'] = null;


        $project->update($project_data);

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@general_info', $id);
    }

    /**
     * Show the calculation page
     *
     * @param $id
     * @return $this
     */
    public function calculation($id)
    {
        if (!hasPermission('Projects - Edit calculation')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        $groups = [];
        if (count($project->subassembly_groups) > 0) {
            foreach($project->subassembly_groups as $group_item) {
                $groups[$group_item->id] = $group_item->name;
            }
        }

        return view('projects.calculation')->with([
            'project' => $project,
            'subcontractor_operations' => Config::get('calculation.subcontractor_operations'),
            'assemblies' => $project->subassemblies()->whereNull('parent_id')->orderBy('group_id')->get(),
            'subassemblies' => $project->subassemblies,
            'subassembly_groups' => $project->subassembly_groups,
            'groups' => $groups,
            'colors' => Config::get('color.user_colors'),
            'status_colors' => Config::get('color.material_status_colors'),
            'purchasing_statuses' => Config::get('settings.purchasing_statuses')
        ]);
    }

    /**
     * Update project calculation
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calculation_update(Request $request, $id)
    {

        $project = Project::findOrFail($id);

        $req = $request->all();
        $changes_list = [];

        //update subassembly groups
        if (isset($req['subassembly_groups']) && count($req['subassembly_groups']) > 0) {
            foreach ($req['subassembly_groups'] as $k => $group) {
                if ($group['name'] != '') {
                    $subassembly_group = ProjectSubassemblyGroup::find($k);
                    $subassembly_group->name = $group['name'];
                    $subassembly_group->save();
                }
            }
        }

        //add subassembly groups
        if (isset($req['new_subassembly_groups']) && count($req['new_subassembly_groups']) > 0) {
            foreach ($req['new_subassembly_groups'] as $k => $group) {
                if ($group['name'] != '') {
                    $subassembly_group = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => $group['name']]);
                }
            }
        }

        //delete subassembly groups
        if (isset($req['delete_subassembly_groups']) && count($req['delete_subassembly_groups']) > 0) {
            foreach ($req['delete_subassembly_groups'] as $k => $group) {
                ProjectSubassemblyGroup::find($group)->delete();
            }
        }

        //update subassemblies
        $assemblies_count = 0;
        $subassemblies_count = 0;
        if (isset($req['subassemblies']) && count($req['subassemblies']) > 0) {
            foreach ($req['subassemblies'] as $subassembly_id => $item) {
                if (isset($item['parent'])) {
                    $subassemblies_count++;
                }
                else {
                    $assemblies_count++;
                }

                $subassembly_change = false;

                if (isset($item['name'])) {
                    //get group
                    if (!isset($item['group_id']) || (isset($req['delete_subassembly_groups']) && in_array($item['group_id'], $req['delete_subassembly_groups']))) $item['group_id'] = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => trans('General')])->id;

                    //update subassembly
                    $subassembly = ProjectSubassembly::find($subassembly_id);

                    if (!is_null($subassembly)) {
                        if ($subassembly->quantity != $item['subassembly_quantity']) {
                            $subassembly_change = true;
                        }
                        $subassembly->name = $item['name'];
                        $subassembly->group_id = $item['group_id'];
                        $subassembly->quantity = $item['subassembly_quantity'];
                        $subassembly->save();
                    }

                    //update parts
                    if (isset($item['parts']) && count($item['parts']) > 0) {
                        foreach ($item['parts'] as $part_id => $part) {
                            $subassembly_part = ProjectSubassemblyPart::find($part_id);

                            if (!is_null($subassembly_part)) {
                                if ($subassembly_change || $subassembly_part->material_name != $part['material_name'] || $subassembly_part->standard_name != $part['standard_name'] || $subassembly_part->quantity != $part['part_quantity'] || $subassembly_part->length != $part['length'] || $subassembly_part->width != $part['width']) {
                                    $changes_list[str_replace(' ', '-', trim($part['material_name']) . '-' . trim($part['standard_name']))] = 1;
                                }

                                $material = SettingsMaterial::get_material_by_name($part['material_name']);
                                $standard = SettingsStandard::orWhere('EN', $part['standard_name'])->orWhere('DIN_SEW', $part['standard_name'])->first();

                                $subassembly_part->name = $part['part'];
                                $subassembly_part->quantity = $part['part_quantity'];
                                $subassembly_part->material_name = $part['material_name'];
                                if (!is_null($material)) {
                                    $subassembly_part->material_id = $material->id;
                                }
                                else {
                                    $subassembly_part->material_id = null;
                                }
                                $subassembly_part->standard_name = $part['standard_name'];
                                if (!is_null($standard)) {
                                    $subassembly_part->standard_id = $standard->id;
                                }
                                else {
                                    $subassembly_part->standard_id = null;
                                }
                                $subassembly_part->length = $part['length'];
                                $subassembly_part->width = $part['width'];
                                $subassembly_part->save();
                            }

                        }
                    }

                    //add new parts
                    if (isset($item['new_parts']) && count($item['new_parts']) > 0) {
                        foreach ($item['new_parts'] as $part_id => $part) {
                            $material = SettingsMaterial::get_material_by_name($part['material_name']);
                            $standard = SettingsStandard::orWhere('EN', $part['standard_name'])->orWhere('DIN_SEW', $part['standard_name'])->first();

                            ProjectSubassemblyPart::create(['name' => $part['part'], 'project_id' => $id, 'subassembly_id' => $subassembly_id, 'quantity' => $part['part_quantity'], 'material_name' => $part['material_name'], 'material_id' => !is_null($material) ? $material->id : null, 'standard_name' => $part['standard_name'], 'standard_id' => !is_null($standard) ? $standard->id : null, 'length' => $part['length'], 'width' => $part['width']]);
                        }
                    }
                }

            }
        }

        //dd($req['new_subassemblies']);
        //add subassemblies
        $new_assemblies_count = 0;
        $new_subassemblies_count = 0;
        $assemblies_without_name = 0;
        $subassemblies_without_name = 0;
        $new_parent_ids = [];
        if (isset($req['new_subassemblies']) && count($req['new_subassemblies']) > 0) {
            foreach ($req['new_subassemblies'] as $k => $item) {

                if ($k !== 'temp') {
                    if (isset($item['parent'])) {
                        $new_subassemblies_count++;
                    }
                    else {
                        $new_assemblies_count++;
                    }

                    if ($item['name'] == '') {
                        $has_parts = false;
                        $has_children = false;

                        if (isset($item['new_parts']) && count($item['new_parts']) > 0) {
                            foreach ($item['new_parts'] as $part_id => $part) {
                                if ($part['material_name'] != '') {
                                    $has_parts = true;
                                }
                            }
                        }

                        foreach ($req['new_subassemblies'] as $key => $new_item) {
                            if (isset($new_item['parent']) && $new_item['parent'] == 'new-' . $k ) {
                                $has_children = true;
                            }
                        }


                        if ($has_parts || $has_children) {
                            $item['name'] = (isset($item['parent']) ? 'SA' : 'A') . (isset($item['parent']) ? ++$subassemblies_without_name + $new_subassemblies_count + $subassemblies_count : ++$assemblies_without_name + $new_assemblies_count + $assemblies_count);
                            $item['subassembly_quantity'] = (!isset($item['subassembly_quantity']) || $item['subassembly_quantity'] == '' || $item['subassembly_quantity'] == 0) ? 1 : $item['subassembly_quantity'];
                        }
                    }


                    if (!isset($item['group_id']) || (isset($req['delete_subassembly_groups']) && in_array($item['group_id'], $req['delete_subassembly_groups']))) $item['group_id'] = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => trans('General')])->id;

                    //create subassembly
                    $subassembly = ProjectSubassembly::create(['name' => $item['name'], 'group_id' => $item['group_id'], 'project_id' => $id, 'quantity' => $item['subassembly_quantity'], 'parent_id' => isset($item['parent']) ? (isset($new_parent_ids[$item['parent']]) ? $new_parent_ids[$item['parent']] : $item['parent'] ) : null]);

                    //put the new id into parent ids array
                    $new_parent_ids['new-' . $k] = $subassembly->id;

                    //add new parts
                    if (isset($item['new_parts']) && count($item['new_parts']) > 0) {
                        foreach ($item['new_parts'] as $part_id => $part) {
                            if ($part['material_name'] != '') {
                                $material = SettingsMaterial::get_material_by_name($part['material_name']);
                                $standard = SettingsStandard::orWhere('EN', $part['standard_name'])->orWhere('DIN_SEW', $part['standard_name'])->first();

                                ProjectSubassemblyPart::create(['name' => $part['part'], 'project_id' => $id, 'subassembly_id' => $subassembly->id, 'quantity' => $part['part_quantity'], 'material_name' => $part['material_name'], 'material_id' => !is_null($material) ? $material->id : null, 'standard_name' => $part['standard_name'], 'standard_id' => !is_null($standard) ? $standard->id : null, 'length' => $part['length'], 'width' => $part['width']]);

                                $changes_list[str_replace(' ', '-', trim($part['material_name']) . '-' . trim($part['standard_name']))] = 1;
                            }
                        }
                    }
                }

            }
        }

        //delete subassemblies
        if (isset($req['delete_subassemblies']) && count($req['delete_subassemblies']) > 0) {
            foreach ($req['delete_subassemblies'] as $k => $item) {
                $subassembly_obj = ProjectSubassembly::find($item);
                if (!is_null($subassembly_obj)) $subassembly_obj->delete();

                $parts = ProjectSubassemblyPart::where('subassembly_id', $item)->get();
                foreach ($parts as $part) {
                    $changes_list[str_replace(' ', '-', trim($part->material_name) . '-' . trim($part->standard_name))] = 1;

                    //remove from materials list
                    if (ProjectSubassemblyPart::where('project_id', $id)->where('material_id', $part->material_id)->where('standard_id', $part->standard_id)->count() == 1) {
                        foreach ($req['materials'] as $i => $material_type) {
                            foreach ($material_type as $k => $material) {
                                if ($material['name'] == $part->material_name && $material['quality'] == $part->standard_name) {
                                    unset($req['materials'][$i][$k]);
                                }
                            }
                        }
                    }

                    //add canceled status in inventroy list
                    $project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $part->material_id)->where('standard_id', $part->standard_id)->first();
                    if (!is_null($project_material)) {
                        $project_material->canceled = 1;
                        $project_material->save();
                    }
                    $part->delete();
                }

            }
        }

        //delete subassembly parts
        if (isset($req['delete_subassembly_parts']) && count($req['delete_subassembly_parts']) > 0) {
            foreach ($req['delete_subassembly_parts'] as $k => $item) {
                $part = ProjectSubassemblyPart::find($item);

                //remove from materials list
                if (!is_null($part) && ProjectSubassemblyPart::where('project_id', $id)->where('material_id', $part->material_id)->where('standard_id', $part->standard_id)->count() == 1) {
                    $changes_list[str_replace(' ', '-', trim($part->material_name) . '-' . trim($part->standard_name))] = 1;

                    foreach ($req['materials'] as $i => $material_type) {
                        foreach ($material_type as $k => $material) {
                            if ($material['name'] == $part->material_name && $material['quality'] == $part->standard_name) {
                                unset($req['materials'][$i][$k]);
                            }
                        }
                    }

                    //add canceled status in inventroy list
                    $project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $part->material_id)->where('standard_id', $part->standard_id)->first();
                    if (!is_null($project_material)) {
                        $project_material->canceled = 1;
                        $project_material->save();
                    }


                    $part->delete();
                }
            }
        }

        //changes in subassemblies list -> override materials list
        $materials_list = [];
        if (isset($req['subassemblies-change']) && $req['subassemblies-change']) {
            if (!is_null($project->subassembly_parts) && count($project->subassembly_parts) > 0) {
                foreach ($project->subassembly_parts as $item) {

                    $material = SettingsMaterial::get_material_by_name($item['material_name']);
                    $standard = SettingsStandard::orWhere('EN', $item['standard_name'])->orWhere('DIN_SEW', $item['standard_name'])->first();

                    if (!is_null($material)) {
                        $index = str_replace(' ', '-', trim($item['material_name']) . '-' . trim($item['standard_name']));

                        if (isset($changes_list[$index]) || !isset($project->calculation) || !isset($project->calculation->data) || !isset($project->calculation->data->materials) || !isset($project->calculation->data->materials->{$material->material_type()}) || !isset($project->calculation->data->materials->{$material->material_type()}->{$index})) {
                            switch ($material->type) {
                                case 'main':
                                    if (is_null($material->thickness) || $material->thickness == 0) { //profile
                                        if (isset($materials_list['profile'][$index])) {
                                            $length = $materials_list['profile'][$index]['length_net'];
                                            $net_sizes = $materials_list['profile'][$index]['net_sizes'];
                                        } else {
                                            $length = 0;
                                            $net_sizes = array();
                                            $net_sizes[] = array('length' => 0);
                                        }
                                        for ($i = 0; $i < $item['quantity'] * $item->subassembly->quantity * $item->subassembly->parent->quantity; $i++) {
                                            array_unshift($net_sizes, array('length' => round(($item['length'] / 1000), 2)));
                                        }

                                        $materials_list['profile'][$index] = array('name' => $item['material_name'], 'quality' => $item['standard_name'], 'net_sizes' => $net_sizes, 'length_net' => $length + round(($item['length'] / 1000) * $item->subassembly->parent->quantity * $item->subassembly->quantity * $item['quantity'], 2), 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                    } else { //plate
                                        if (isset($materials_list['plate'][$index])) {
                                            $surface = $materials_list['plate'][$index]['necessary_net'];
                                            $quantity = $materials_list['plate'][$index]['quantity'];
                                            $net_sizes = $materials_list['plate'][$index]['net_sizes'];
                                            $gross_sizes = $materials_list['plate'][$index]['gross_sizes'];
                                        } else {
                                            $surface = 0;
                                            $quantity = 0;
                                            $net_sizes = array();
                                            $net_sizes[] = array('length' => 0, 'width' => 0);
                                            $gross_sizes = array();
                                            $gross_sizes[] = array('length' => '', 'width' => '');
                                        }
                                        for ($i = 0; $i < $item['quantity'] * $item->subassembly->quantity * $item->subassembly->parent->quantity; $i++) {
                                            array_unshift($net_sizes, array('length' => $item['length'], 'width' => $item['width']));
                                            array_unshift($gross_sizes, array('length' => $item['length'] + 10, 'width' => $item['width'] + 10));
                                        }
                                        $materials_list['plate'][$index] = array('name' => $item['material_name'], 'quality' => $item['standard_name'], 'quantity' => $quantity + ($item['quantity'] * $item->subassembly->quantity * $item->subassembly->parent->quantity), 'thickness' => $material->thickness, 'net_sizes' => $net_sizes, 'gross_sizes' => $gross_sizes, 'necessary_net' => $surface + round(($item['length'] / 1000) * ($item['width'] / 1000) * $item->subassembly->parent->quantity * $item->subassembly->quantity * $item['quantity'], 2), 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                    }
                                    break;
                                case 'assembly':
                                    if (isset($materials_list['assembly'][$index])) {
                                        $length = $materials_list['assembly'][$index]['length_net'];
                                    } else {
                                        $length = 0;
                                    }

                                    $materials_list['assembly'][$index] = array('name' => $item['material_name'], 'length' => $item['length'] + $length, 'quality' => $item['standard_name'], 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                    break;
                                default:
                                    $materials_list['other'][$index] = array('name' => $item['material_name'], 'quantity' => $item['quantity'], 'quality' => $item['standard_name'], 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                            }

                            //add canceled status in inventroy list
                            if (!is_null($material) && !is_null($standard)) {
                                $project_materials = ProjectMaterial::where('project_id', $id)->where('material_id', $material->id)->where('standard_id', $standard->id)->get();
                                if (count($project_materials)) {
                                    foreach ($project_materials as $project_material) {
                                        $project_material->canceled = 1;
                                        $project_material->save();
                                    }
                                }
                            }
                        }
                        else {
                            $materials_list[$material->material_type()][$index] = (array) json_decode(json_encode($project->calculation->data->materials->{$material->material_type()}->{$index}));
                        }
                    }
                }
            }

            if (isset($req['materials']['paint'])) {
                $materials_list['paint'] = $req['materials']['paint'];
            }
            if (isset($req['materials']['auxiliary'])) {
                $materials_list['auxiliary'] = $req['materials']['auxiliary'];
            }
            $req['materials'] = $materials_list;
        }

        //update materials list & send materials to purchasing
        $purchase_materials = array();
        if (isset($req['materials']) && count($req['materials']) > 0) {
            foreach ($req['materials'] as $type => $material_type) {
                foreach ($material_type as $k => $material) {
                    if (isset($material['name']) && $material['name'] != '') {
                        $material_info = SettingsMaterial::get_material_by_name($material['name']);
                        $req['materials'][$type][$k]['material'] = $material_info;
                        if (isset($material['quality'])) $req['materials'][$type][$k]['standard'] = SettingsStandard::orWhere('EN', $material['quality'])->orWhere('DIN_SEW', $material['quality'])->first();

                        //send materials to purchasing
                            if (isset($req['send-to-purchasing']) || isset($req['send-order-request'])) {
                                switch ($type) {
                                    case 'profile':
                                        foreach($material['gross_sizes'] as $i => $mat) {
                                            if (isset($req['selected_materials']['profile'][$k][$i]) && isset($mat['length']) && $mat['length'] != '' && $mat['length'] != 0 && isset($req['selected_materials']['profile'])) {
                                                $quantity = $mat['length'];
                                                $purchase_materials[] = ['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''), 'quantity' => $quantity, 'size' => $mat['length'], 'net_size' => $material['net_sizes'][$i]['length'], 'net_quantity' => $material['net_sizes'][$i]['length'], 'index' => $i];

                                                /*$project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material_info->id)->where('standard_id', (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''))->first();
                                                if (is_null($project_material)) {
                                                    $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                                } elseif ($project_material->quantity != $material['length_gross']) {
                                                    $project_material->canceled = 1;
                                                    $project_material->save();

                                                    $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                                }
                                                $project_material->quantity = count($req['selected_materials']['profile'][$k]);
                                                $project_material->size = $material['length_gross'];
                                                $project_material->save();
                                                $req['materials'][$type][$k]['project_material_id'] = $project_material->id;*/
                                            }
                                        }
                                        break;
                                    case 'plate':
                                        foreach($material['gross_sizes'] as $i => $mat) {
                                            if (isset($req['selected_materials']['plate'][$k][$i]) && isset($mat['length']) && $mat['length'] != '' && $mat['length'] != 0 && isset($mat['width']) && $mat['width'] != '' && $mat['width'] != 0) {
                                                $quantity = $mat['weight'];
                                                $purchase_materials[] = ['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''), 'quantity' => $quantity, 'size' => $mat['length'] . 'x' . $mat['width'], 'net_size' => $material['net_sizes'][$i]['length'] . 'x' . $material['net_sizes'][$i]['width'], 'net_quantity' => $material['net_sizes'][$i]['weight'], 'index' => $i];

                                                /*$project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material_info->id)->where('standard_id', (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''))->first();
                                                if (is_null($project_material)) {
                                                    $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                                } elseif ($project_material->quantity != $material['weight_gross']) {
                                                    $project_material->canceled = 1;
                                                    $project_material->save();

                                                    $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                                }
                                                $project_material->quantity = $material['weight_gross'];
                                                $project_material->save();
                                                $req['materials'][$type][$k]['project_material_id'] = $project_material->id;*/

                                            }
                                        }
                                        break;
                                    case 'assembly':
                                        if (isset($req['selected_materials']['assembly'][$k]) && isset($material['quantity']) && $material['quantity'] != '' && $material['quantity'] != 0 && isset($material['length']) && $material['length'] != 0) {
                                            $quantity = $material['quantity'];
                                            $purchase_materials[] = ['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''), 'quantity' => $quantity, 'size' => $material['length'], 'net_size' => isset($material['length']) ? $material['length'] : '', 'net_quantity' => isset($material['length']) ? $material['length'] : '', 'index' => 0];

                                            /*$project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material_info->id)->where('standard_id', (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''))->first();
                                            if (is_null($project_material)) {
                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                            } elseif ($project_material->quantity != $material['quantity']) {
                                                $project_material->canceled = 1;
                                                $project_material->save();

                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                            }
                                            $project_material->quantity = $material['quantity'];
                                            $project_material->save();
                                            $req['materials'][$type][$k]['project_material_id'] = $project_material->id;
                                            */
                                        }
                                        break;
                                    case 'other':
                                        if (isset($req['selected_materials']['other'][$k]) && isset($material['quantity']) && $material['quantity'] != '' && $material['quantity'] != 0) {
                                            $quantity = $material['quantity'];
                                            $purchase_materials[] = ['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''), 'quantity' => $quantity, 'size' => '', 'net_size' => '', 'net_quantity' => '', 'index' => 0];

                                            /*$project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material_info->id)->where('standard_id', (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : ''))->first();
                                            if (is_null($project_material)) {
                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                            } elseif ($project_material->quantity != $material['quantity']) {
                                                $project_material->canceled = 1;
                                                $project_material->save();

                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id, 'standard_id' => (isset($req['materials'][$type][$k]['standard']) ? $req['materials'][$type][$k]['standard']->id : '')]);
                                            }
                                            $project_material->quantity = $material['quantity'];
                                            $project_material->save();
                                            $req['materials'][$type][$k]['project_material_id'] = $project_material->id;
                                            */
                                        }
                                        break;
                                    case 'paint':
                                    case 'auxiliary':
                                        if (isset($material['necessary']) && $material['necessary'] != '' && $material['necessary'] != 0) {
                                            /*$project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material_info->id)->first();
                                            if (is_null($project_material)) {
                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id]);
                                            } elseif ($project_material->quantity != $material['necessary']) {
                                                $project_material->canceled = 1;
                                                $project_material->save();

                                                $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material_info->id]);
                                            }
                                            $project_material->quantity = $material['necessary'];
                                            $project_material->save();
                                            $req['materials'][$type][$k]['project_material_id'] = $project_material->id;
                                            */
                                        }
                                        break;
                                }
                            }

                    }
                }
            }
        }

        foreach ($purchase_materials as $material) {
            $project_material = ProjectMaterial::where('project_id', $id)->where('material_id', $material['material_id'])->where('standard_id', $material['standard_id'])->where('material_no', $material['index'])->where('canceled', 0)->first();

            if (isset($req['send-to-purchasing'])) {
                if (!is_null($project_material) && $project_material->quantity != $material['quantity']) {
                    $project_material->canceled = 1;
                    $project_material->save();
                }

                if (is_null($project_material) || (!is_null($project_material) && $project_material->quantity != $material['quantity'])) {
                    $project_material = ProjectMaterial::create(['project_id' => $id, 'material_id' => $material['material_id'], 'standard_id' => $material['standard_id'], 'size' => $material['size'], 'net_size' => $material['net_size'], 'net_quantity' => $material['net_quantity'], 'quantity' => $material['quantity'], 'material_no' => $material['index']]);
                }
                $req['materials'][$type][$k]['gross_sizes'][$material['index']]['project_material_id'] = $project_material->id;
            }

            //send order request
            if (isset($req['send-order-request']) && !is_null($project_material)) {
                $project_material->order_request = 1;
                $project_material->save();
            }

        }


        unset($req['subassemblies-change']);
        unset($req['subassemblies']);
        unset($req['subassembly_groups']);

        //remember saved total
        if (!isset($req['total']) && isset($project->calculation->data->total)) {
            $req['total'] = $project->calculation->data->total;
        }

        if ($project->calculation != null) {
            $project->calculation()->update([
                'data' => json_encode($req)
            ]);
        }
        else {
            $project->calculation()->save(new ProjectCalculation([
                'data' => json_encode($req)
            ]));
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@calculation', [$id, $req['active_tab']]);
    }

    /**
     * Import materials from xls
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function materials_upload(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            //wrong extension
            $extension = $file->getClientOriginalExtension();
            if (!($extension == 'xls' || $extension == 'xlsx')) {
                Session::flash('error_msg', trans('Extensia fișierului este nepermisă. Se poate încărca numai fișiere xls sau xlsx.'));
                return redirect()->action('ProjectsController@calculation', $id);
            }

            //check if the temp folder exist (if the folder does not exist, create it)
            if (!Storage::exists('temp')) {
                Storage::makeDirectory('temp');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('temp/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('temp/' . $filename, File::get($file));

            //import excel
            $error_message = '';
            Excel::load(storage_path('app') . '/temp/' . $filename, function($reader) use ($id, &$error_message) {

                $results = $reader->get();

                $project = Project::findOrFail($id);
                $materials_list = [];

                if (count($results) > 0) {
                    foreach ($results as $row) {
                        if (!isset($row->ansamblu) || !isset($row->cantitate_ansamblu) || !isset($row->grupa_ansamblu) || !isset($row->subansamblu) || !isset($row->cantitate_subansamblu) || !isset($row->reper) || !isset($row->cantitate_reper) || !isset($row->calitate) || !isset($row->material) || !isset($row->lungime) || !isset($row->latime)) {
                            $error_message = trans('Formatul fisierului xls este gresit.');
                        }
                        else {
                            if ($row->ansamblu != '') {
                                if (is_null($row->grupa_ansamblu)) {
                                    $group = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => trans('General')]);
                                } else {
                                    $group = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => $row->grupa_ansamblu]);
                                }

                                $assembly = ProjectSubassembly::firstOrCreate(['name' => $row->ansamblu, 'group_id' => $group->id, 'project_id' => $id]);
                                $assembly->quantity = (is_null($row->cantitate_ansamblu) || $row->cantitate_ansamblu == '') ? 1 : $row->cantitate_ansamblu;
                                $assembly->save();


                                if ($row->subansamblu != '') {

                                    $subassembly = ProjectSubassembly::firstOrCreate(['name' => $row->subansamblu, 'group_id' => $group->id, 'project_id' => $id, 'parent_id' => $assembly->id]);
                                    $subassembly->quantity = (is_null($row->cantitate_subansamblu) || $row->cantitate_subansamblu == '') ? 1 : $row->cantitate_subansamblu;
                                    $subassembly->save();

                                    $material = SettingsMaterial::get_material_by_name($row->material);
                                    $standard = SettingsStandard::orWhere('EN', $row->calitate)->orWhere('DIN_SEW', $row->calitate)->first();
                                    $subassembly_part = ProjectSubassemblyPart::firstOrCreate(['name' => is_null($row->reper) ? '' : $row->reper, 'project_id' => $id, 'subassembly_id' => $subassembly->id]);
                                    $subassembly_part->quantity = (is_null($row->cantitate_reper) || $row->cantitate_reper == '') ? 1 : $row->cantitate_reper;
                                    $subassembly_part->material_name = $row->material;
                                    if (!is_null($material)) {
                                        $subassembly_part->material_id = $material->id;
                                    }
                                    $subassembly_part->standard_name = $row->calitate;
                                    if (!is_null($standard)) {
                                        $subassembly_part->standard_id = $standard->id;
                                    }
                                    $subassembly_part->length = $row->lungime;
                                    $subassembly_part->width = $row->latime;
                                    $subassembly_part->save();

                                    //add to materials list
                                    if (!is_null($material)) {
                                        $index = str_replace(' ', '-', trim($row->material)) . '-' . trim($row->calitate);
                                        $quantity = $row->cantitate_ansamblu * $row->cantitate_subansamblu * $row->cantitate_reper;
                                        switch ($material->type) {
                                            case 'main':
                                                if (is_null($material->thickness) || $material->thickness == 0) { //profile
                                                    if (isset($materials_list['profile'][$index])) {
                                                        $length = $materials_list['profile'][$index]['length_net'];
                                                        $net_sizes = $materials_list['profile'][$index]['net_sizes'];
                                                    } else {
                                                        $length = 0;
                                                        $net_sizes = array();
                                                    }
                                                    for ($i = 0; $i < $row->cantitate_ansamblu * $row->cantitate_subansamblu * $row->cantitate_reper; $i++) {
                                                        $net_sizes[] = array('length' => round(($row->lungime / 1000), 2));
                                                    }
                                                    $materials_list['profile'][$index] = array('name' => !is_null($material) ? $material->name : $row->material, 'quality' => $row->calitate, 'net_sizes' => $net_sizes, 'length_net' => $length + round(($row->lungime / 1000) * $row->cantitate_ansamblu * $row->cantitate_subansamblu * $row->cantitate_reper, 2), 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                                } else { //plate
                                                    if (isset($materials_list['plate'][$index])) {
                                                        $surface = $materials_list['plate'][$index]['necessary_net'];
                                                        $quantity = $materials_list['plate'][$index]['quantity'];
                                                        $net_sizes = $materials_list['plate'][$index]['net_sizes'];
                                                        $gross_sizes = $materials_list['plate'][$index]['gross_sizes'];
                                                    } else {
                                                        $surface = 0;
                                                        $quantity = 0;
                                                        $net_sizes = array();
                                                        $gross_sizes = array();
                                                    }
                                                    for ($i = 0; $i < $row->cantitate_ansamblu * $row->cantitate_subansamblu * $row->cantitate_reper; $i++) {
                                                        $net_sizes[] = array('length' => $row->lungime, 'width' => $row->latime);
                                                        $gross_sizes[] = array('length' => $row->lungime + 10, 'width' => $row->latime + 10);
                                                    }
                                                    $materials_list['plate'][$index] = array('name' => !is_null($material) ? $material->name : $row->material, 'quantity' => $quantity + ($row->cantitate_ansamblu * $row->cantitate_subansamblu * $row->cantitate_reper), 'quality' => $row->calitate, 'thickness' => $material->thickness, 'net_sizes' => $net_sizes, 'gross_sizes' => $gross_sizes, 'necessary_net' => $surface + round(($row->lungime / 1000) * ($row->latime / 1000) * $row->cantitate_subansamblu * $row->cantitate_reper, 2), 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                                }
                                                break;
                                            case 'assembly':
                                                if (isset($materials_list['assembly'][$index])) {
                                                    $length = $materials_list['assembly'][$index]['length_net'];
                                                } else {
                                                    $length = 0;
                                                }

                                                $materials_list['assembly'][$index] = array('name' => !is_null($material) ? $material->name : $row->material, 'length' => $row->lungime + $length, 'quality' => $row->calitate, 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                                break;
                                            default:
                                                $materials_list['other'][$index] = array('name' => !is_null($material) ? $material->name : $row->material, 'quantity' => $quantity, 'quality' => $row->calitate, 'material' => $material, 'standard' => $standard, 'project_material_id' => '');
                                        }

                                    }
                                }
                            }
                        }
                    }

                    if ($project->calculation != null) {
                        $data = $project->calculation->data;

                        //merge new materials list with old material list
                        if (!is_null($data->materials)) {
                            foreach($data->materials as $type => $material_type) {
                                foreach ($material_type as $k => &$material_item) {
                                    $index = str_replace(' ', '-', trim($material_item->name)) . (isset($material_item->quality) ? '-' . trim($material_item->quality) : '');
                                    if (isset($materials_list[$type][$index])) {
                                        if ($type == 'plate') {
                                            $material_item->necessary_net = $material_item->necessary_net + $materials_list[$type][$index]['necessary_net'];
                                        }
                                        else {
                                            $material_item->length_net = $material_item->length_net + $materials_list[$type][$index]['length_net'];
                                        }
                                        unset($materials_list[$type][$index]);

                                    }
                                }
                            }

                            $materials = [];
                            foreach ($materials_list as $type => $material_type) {
                                foreach ($material_type as $k => $material) {
                                    $materials[$type][] = $material;
                                }
                            }

                            $data->materials = array_merge_recursive(is_array($data->materials) ? $data->materials : get_object_vars($data->materials), $materials);
                        }


                        $project->calculation()->update([
                            'data' => json_encode($data)
                        ]);
                    }
                    else {
                        $materials = [];
                        foreach ($materials_list as $type => $material_type) {
                            foreach ($material_type as $k => $material) {
                                $materials[$type][] = $material;
                            }
                        }
                        $project->calculation()->save(new ProjectCalculation([
                            'data' => json_encode(array('materials' => $materials))
                        ]));
                    }
                }
            });

            //remove temp file
            if (Storage::exists('temp/' . $filename)) {
                Storage::delete(['temp/' . $filename]);
            }

            if ($error_message != '') {
                Session::flash('error_msg', trans('Formatul fisierului xls este gresit.'));

                return redirect()->action('ProjectsController@subassemblies', $id);
            }

            Session::flash('success_msg', trans('Înregistrările au fost create cu succes'));
            return redirect()->action('ProjectsController@calculation', $id);
        }
        else {
            Session::flash('error_msg', trans('Fișier inexistent'));
            return redirect()->action('ProjectsController@calculation', $id);
        }

    }


    /**
     * Display a listing of the offers.
     *
     * @param $id
     * @return $this
     */
    public function offers($id)
    {
        if (!hasPermission('Projects - Offers list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.offers.index')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload offers files for a project
     *
     * @param $id
     * @return string
     */
    public function offers_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/offers')) {
                Storage::makeDirectory('projects/' . $id . '/offers');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/offers/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/offers/' . $filename, File::get($file));


            //add offers to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/offers/' . $filename]);

            $project->output_offers()->save(new ProjectOutputOffer([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of offers from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function offers_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $offer_id) {

                $offer = ProjectOutputOffer::findOrFail($offer_id);
                $file = \App\Models\File::findOrfail($offer->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $offer->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@offers', $id);

    }

    /**
     * Display a listing of the contracts.
     *
     * @param $id
     * @return $this
     */
    public function contracts($id)
    {
        if (!hasPermission('Projects - Contracts list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.contracts.index')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload contracts files for a project
     *
     * @param $id
     * @return string
     */
    public function contracts_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/contracts')) {
                Storage::makeDirectory('projects/' . $id . '/contracts');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/contracts/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/contracts/' . $filename, File::get($file));


            //add contracts to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/contracts/' . $filename]);

            $project->contracts()->save(new ProjectContract([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of contracts from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function contracts_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $contract_id) {

                $contract = ProjectContract::findOrFail($contract_id);
                $file = \App\Models\File::findOrfail($contract->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $contract->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@contracts', $id);

    }


    /**
     * Display the control plan form
     *
     * @param $id
     * @return mixed
     */
    public function control_plan($id)
    {
        if (!hasPermission('Projects - Control plan')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.control_plan')->with('project', $project)->with('control_plan_categories', ProjectControlPlanCategory::all());
    }

    /**
     * Update the control plan of specified project in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function control_plan_update(Request $request, $id)
    {
        $project = Project::findOrFail($id);


        if ($request->has('item')) {
            $control_plan_item = ProjectControlPlan::where('item_id', $request->input('item'))->where('project_id', $id)->first();

            if (!is_null($control_plan_item)) {
                $control_plan_item->date = Carbon::now();
                $control_plan_item->user_id = Auth::id();
                $control_plan_item->status = 1;

                $control_plan_item->save();
            }
            else {
                ProjectControlPlan::create(['project_id' => $id, 'item_id' => $request->input('item'), 'date' => Carbon::now(), 'status' => 1, 'user_id' => Auth::id()]);
            }
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@control_plan', $id);
    }

    /**
     * Display a listing of the cutting drawings.
     *
     * @param $id
     * @return mixed
     */
    public function cuttings($id)
    {
        if (!hasPermission('Projects - Cuttings list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.cutting')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload cutting files for a project
     *
     * @param $id
     * @return string
     */
    public function cuttings_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/cuttings')) {
                Storage::makeDirectory('projects/' . $id . '/cuttings');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/cuttings/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/cuttings/' . $filename, File::get($file));


            //add cuttings to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/cuttings/' . $filename]);

            $project->cuttings()->save(new ProjectCutting([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of cutting files from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function cuttings_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $cutting_id) {

                $cutting = ProjectCutting::findOrFail($cutting_id);
                $file = \App\Models\File::findOrfail($cutting->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $cutting->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@cuttings', $id);

    }



    /**
     * Display data sheet page for a specified project
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function datasheet($id, $show = null)
    {
        if (!hasPermission('Projects - Edit datasheet')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        //json decode data
        $data = null;
        if ($project->datasheet != null) {
            $data = $project->datasheet->data;
        }

        //subassemblies/parts by groups & materials standards
        $standards = array();
        $subassembly_groups = array();
        if (count($project->subassembly_groups) > 0) {
            foreach ($project->subassembly_groups as $group) {
                $subassembly_groups[$group->name]['id'] = $group->id;
                if (count($group->assemblies) > 0) {
                    foreach ($group->assemblies as $assembly) {
                        $subassembly_groups[$group->name]['children'][$assembly->name]['id'] = $assembly->id;
                        if (count($assembly->children) > 0) {
                            foreach ($assembly->children as $subassembly) {
                                $subassembly_groups[$group->name]['children'][$assembly->name]['children'][$subassembly->name]['id'] = $subassembly->id;

                                foreach ($subassembly->parts as $part) {
                                    $subassembly_groups[$group->name]['children'][$assembly->name]['children'][$subassembly->name]['children'][$part->id] = $part->name;


                                    $standards[$part->standard_id]['name'] = $part->standard_name;
                                    $standards[$part->standard_id]['children'][$group->name]['id'] = $group->id;
                                    $standards[$part->standard_id]['children'][$group->name]['children'][$assembly->name]['id'] = $assembly->id;
                                    $standards[$part->standard_id]['children'][$group->name]['children'][$assembly->name]['children'][$subassembly->name]['id'] = $subassembly->id;
                                    $standards[$part->standard_id]['children'][$group->name]['children'][$assembly->name]['children'][$subassembly->name]['children'][$part->id] = $part->name;
                                }
                            }
                        }
                    }
                }
            }
        }

        return view('projects.datasheet')->with('datasheet', $data)->with('project', $project)->with('subassembly_groups', $subassembly_groups)->with('standards', $standards)->with('show', $show);
    }

    /**
     * Update the data sheet of specified project in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function datasheet_update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($project->datasheet != null) {
            $project->datasheet()->update([
                'data' => json_encode($request->all())
            ]);
        }
        else {
            $project->datasheet()->save(new ProjectDatasheet([
                'data' => json_encode($request->all())
            ]));
        }

        GanttTask::firstOrCreate(['text' => 'Aprovizionare', 'operation' => 'supply', 'sortorder' => 1, 'project_id' => $id]);
        if ($project->has_cutting()) GanttTask::firstOrCreate(['text' => 'Debitare', 'operation' => 'cutting', 'sortorder' => 2, 'project_id' => $id]);
        else GanttTask::where(['operation' => 'cutting', 'project_id' => $id])->delete();
        if ($project->has_processing()) GanttTask::firstOrCreate(['text' => 'Prelucrare', 'operation' => 'processing', 'sortorder' => 3,  'project_id' => $id]);
        else GanttTask::where(['operation' => 'processing', 'project_id' => $id])->delete();
        if ($project->has_locksmithing()) GanttTask::firstOrCreate(['text' => 'Lacatuserie', 'operation' => 'locksmithing', 'sortorder' => 4, 'project_id' => $id]);
        else GanttTask::where(['operation' => 'locksmithing', 'project_id' => $id])->delete();
        if ($project->has_welding()) GanttTask::firstOrCreate(['text' => 'Sudare', 'operation' => 'welding', 'sortorder' => 5, 'project_id' => $id]);
        else GanttTask::where(['operation' => 'welding', 'project_id' => $id])->delete();
        if ($project->has_sanding()) GanttTask::firstOrCreate(['text' => 'Sablare', 'operation' => 'sanding', 'sortorder' => 6, 'project_id' => $id]);
        else GanttTask::where(['operation' => 'sanding', 'project_id' => $id])->delete();
        if ($project->has_painting()) GanttTask::firstOrCreate(['text' => 'Vopsire', 'operation' => 'painting', 'sortorder' => 7, 'project_id' => $id]);
        else GanttTask::where(['operation' => 'painting', 'project_id' => $id])->delete();
        GanttTask::firstOrCreate(['text' => 'Ambalare-Incarcare', 'operation' => 'packaging', 'sortorder' => 8, 'project_id' => $id]);

        //Notifications
        $folder = ProjectFolder::where('route_name', 'projects.datasheet')->first();
        if ($folder->status($project->id) == 'approved' || $folder->status($project->id) == 'completed') {
            NotificationType::send('Projects - Edit finished datasheet', trans('notifications.<b>:user</b> a editat foaia de date cu statusul terminat/aprobat în cazul proiectului: <b>:project</b>', ['user' => Auth::user()->name(), 'project' => $project->production_name() . ' '. $project->customer->short_name . ' ' . $project->name]), action('ProjectsController@datasheet', $project->id));
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@datasheet', $id);
    }

    /**
     * Display subassemblies for a specified project
     *
     * @param $id
     * @return $this
     */
    /*public function subassemblies(Request $request, $id)
    {
        if (!hasPermission('Projects - Edit Subassemblies')) {
            abort(401);
        }

        $project = Project::findOrFail($id);
        $subassemblies_obj = ProjectSubassembly::where('project_subassemblies.project_id', $id);

        //Filters
        if ($request->has('group') && $request->input('group') !='' && $request->input('group') !='0') {
            $subassemblies_obj = $subassemblies_obj->where('group_id', $request->input('group'));
        }

        //Sort
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'group':
                    $subassemblies_obj = $subassemblies_obj->join('project_subassembly_groups as group', 'project_subassemblies.group_id', '=', 'group.id')->orderBy('group.name', $request->input('sort_direction'))->select('project_subassemblies.*', 'group.name as group_name');
                    break;
                default:
                    $subassemblies_obj = $subassemblies_obj->orderBy($request->input('sort'), $request->input('sort_direction'));
            }
        }

        $subassemblies = $subassemblies_obj->get();

        if ($request->ajax()) {
            $view = view('projects._subassamblies_list');
        }
        else {
            $view = view('projects.subassemblies');
        }

        $groups = [];
        if (count($project->subassembly_groups) > 0) {
            foreach($project->subassembly_groups as $group_item) {
                $groups[$group_item->id] = $group_item->name;
            }
        }

        $view = $view->with('subassemblies', $subassemblies)->with([
            'project' => $project,
            'groups' => $groups,
            'assemblies' => $project->subassemblies()->whereNull('parent_id')->orderBy('group_id')->get()
        ]);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }*/

    /**
     * Import subassemblies from xls
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    /*public function subassemblies_upload(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            //wrong extension
            $extension = $file->getClientOriginalExtension();
            if (!($extension == 'xls' || $extension == 'xlsx')) {
                Session::flash('error_msg', trans('Extensia fișierului este nepermisă. Se poate încărca numai fișiere xls sau xlsx.'));
                return redirect()->action('ProjectsController@subassemblies', $id);
            }

            //check if the temp folder exist (if the folder does not exist, create it)
            if (!Storage::exists('temp')) {
                Storage::makeDirectory('temp');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('temp/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('temp/' . $filename, File::get($file));

            //import excel
            $error_message = '';
            Excel::load(storage_path('app') . '/temp/' . $filename, function($reader) use ($id, &$error_message) {

                $results = $reader->get();

                if (count($results) > 0) {
                    foreach ($results as $row) {
                        if (!isset($row->nume) || !isset($row->descriere) || !isset($row->grupa)) {
                            $error_message = trans('Formatul fisierului xls este gresit.');
                        }
                        else {

                            //create the subassembly group
                            if (is_null($row->grupa)) {
                                $group = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => trans('General')]);
                            }
                            else {
                                $group = ProjectSubassemblyGroup::firstOrCreate(['project_id' => $id, 'name' => $row->grupa]);
                            }

                            ProjectSubassembly::create(['name' => $row->nume, 'description' => $row->descriere, 'group_id' => $group->id, 'project_id' => $id]);
                        }
                    }
                }
            });

            //remove temp file
            if (Storage::exists('temp/' . $filename)) {
                Storage::delete(['temp/' . $filename]);
            }

            if ($error_message != '') {
                Session::flash('error_msg', trans('Formatul fisierului xls este gresit.'));

                return redirect()->action('ProjectsController@subassemblies', $id);
            }

            Session::flash('success_msg', trans('Înregistrările au fost create cu succes'));
            return redirect()->action('ProjectsController@subassemblies', $id);
        }

    }*/

    /**
     * Store a newly created subassembly in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subassemblies_store(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        ProjectSubassembly::create($request->all());

        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        return redirect()->action('ProjectsController@subassemblies', $id);
    }

    /**
     * Update subassemblies in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subassemblies_update(Request $request, $id)
    {
        if ($request->has('subassemblies')) {
            $subassemblies = $request->input('subassemblies');

            if (count($subassemblies) > 0) {
                foreach ($subassemblies as $subassembly_id => $subassembly) {
                    $subassembly_obj = ProjectSubassembly::findOrFail($subassembly_id);

                    $subassembly_obj->name = $subassembly['name'];
                    $subassembly_obj->description = $subassembly['description'];
                    $subassembly_obj->group_id = $subassembly['group_id'];

                    $subassembly_obj->save();
                }
            }
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@subassemblies', $id);
    }

    /**
     * Multiple remove of subassemblies from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function subassemblies_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $subassembly_id) {

                $subassembly = ProjectSubassembly::findOrFail($subassembly_id);
                $subassembly->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@subassemblies', $id);
    }

    /**
     * Return subassemblies list
     *
     * @param $id
     * @return mixed
     */
    public function get_subassemblies($id) {
        $term = Input::get('q');

        $subassemblies_obj = ProjectSubassembly::where('project_id', $id);

        //Filters
        if ($term != '') {
            $subassemblies_obj = $subassemblies_obj->where('name', 'LIKE', '%' . $term . '%');
        }

        $subassemblies = $subassemblies_obj->get();

        return $subassemblies;
    }


    /**
     * Display subassembly_groups for a specified project
     *
     * @param $id
     * @return $this
     */
    public function subassembly_groups(Request $request, $id)
    {
        if (!hasPermission('Projects - Edit Subassemblies')) {
            abort(401);
        }

        $project = Project::findOrFail($id);
        $subassembly_groups = ProjectSubassemblyGroup::where('project_id', $id)->get();

        return view('projects.subassembly_groups')->with('subassembly_groups', $subassembly_groups)->with('project', $project)->with('colors', Config::get('color.user_colors'));
    }

    /**
     * Store a newly created subassembly_group in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subassembly_groups_store(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        ProjectSubassemblyGroup::create($request->all());

        Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

        return redirect()->action('ProjectsController@subassembly_groups', $id);
    }

    /**
     * Update subassembly_groups in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subassembly_groups_update(Request $request, $id)
    {
        if ($request->has('subassembly_groups')) {
            $subassembly_groups = $request->input('subassembly_groups');

            if (count($subassembly_groups) > 0) {
                foreach ($subassembly_groups as $group_id => $group) {
                    $group_obj = ProjectSubassemblyGroup::findOrFail($group_id);
                    $group_obj->name = $group['name'];
                    $group_obj->save();
                }
            }
        }


        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@subassembly_groups', $id);
    }

    /**
     * Multiple remove of subassembly_groups from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function subassembly_groups_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $group_id) {

                $group = ProjectSubassemblyGroup::findOrFail($group_id);
                $group->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@subassembly_groups', $id);
    }


    /**
     * Add a responsible to the (sub)assembly group
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subassembly_groups_responsible_store(Request $request, $id)
    {
        $req = $request->all();

        if ($req['user_id'] != 'undefined' && $req['user_id'] != '') {
            ProjectSubassemblyGroupResponsible::firstOrCreate(['group_id' => $req['group_id'], 'user_id' => $req['user_id']]);

            Session::flash('success_msg', trans('Înregistrarea a fost creată cu succes'));

            return redirect()->action('ProjectsController@calculation', [$id, '#calculation-subassembly-groups']);
        }
        else {
            Session::flash('error_msg', trans('Utilizator necunoscut'));

            return redirect()->action('ProjectsController@calculation', [$id, '#calculation-subassembly-groups']);
        }

    }

    /**
     * Remove responsible of subassembly_groups from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function subassembly_groups_responsible_destroy(Request $request, $id)
    {
        $req = $request->all();

        ProjectSubassemblyGroupResponsible::where('group_id', $req['group_id'])->where('user_id', $req['user_id'])->delete();

        Session::flash('success_msg', trans('Înregistrarea a fost ștearsă cu succes'));

        return redirect()->action('ProjectsController@calculation', [$id, '#calculation-subassembly-groups']);
    }


    /**
     * Display drawings for a specified project
     *
     * @param $id
     * @return $this
     */
    public function drawings($id)
    {
        if (!hasPermission('Projects - Edit drawings')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.drawings')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Update drawings in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function drawings_update(Request $request, $id)
    {
        //send drawings to quality control
        if ($request->has('send-qa')) {
            $project = Project::findOrFail($id);

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'select_') !== false && $key != 'select_all') {
                    $drawing_id = $value;

                    if (ProjectQualityControlDrawing::where('project_id', $id)->where('drawing_id', $drawing_id)->count() == 0) {
                        $project->quality_control_drawings()->save(new ProjectQualityControlDrawing([
                            'drawing_id' => $drawing_id
                        ]));
                    }
                }
            }

        }
        //remove drawings from quality control list
        elseif ($request->has('remove-qa')) {
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'select_') !== false && $key != 'select_all') {
                    $drawing_id = $value;
                    ProjectQualityControlDrawing::where('project_id', $id)->where('drawing_id', $drawing_id)->delete();
                }
            }
        }
        //drawing update
        else {
            if ($request->has('drawings')) {
                $drawings = $request->input('drawings');

                if (count($drawings) > 0) {
                    foreach ($drawings as $drawing_id => $drawing) {
                        $drawing_obj = ProjectDrawing::findOrFail($drawing_id);

                        $drawing_obj->name = $drawing['name'];
                        $drawing_obj->description = $drawing['description'];

                        $drawing_obj->save();

                        //update subassembly
                        if ($drawing['subassembly_id'] != '') {
                            $subassambly = ProjectSubassembly::find($drawing['subassembly_id']);
                            $subassambly->drawing_id = $drawing_id;
                            $subassambly->save();
                        }
                    }
                }
            }
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@drawings', $id);
    }

    /**
     * Upload drawings files for a project
     *
     * @param $id
     * @return string
     */
    public function drawings_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/drawings')) {
                Storage::makeDirectory('projects/' . $id . '/drawings');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/drawings/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/drawings/' . $filename, File::get($file));


            //add drawings to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/drawings/' . $filename]);

            $project->drawings()->save(new ProjectDrawing([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple remove of drawings from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function drawings_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $drawing_id) {

                $drawing = ProjectDrawing::findOrFail($drawing_id);
                $file = \App\Models\File::findOrfail($drawing->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $drawing->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@drawings', $id);
    }

    /**
     * Display qa drawings/files of the specified project
     *
     * @param $id
     * @return mixed
     */
    public function drawings_qa($id)
    {
        if (!hasPermission('Projects - Edit QA drawings')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.drawings_qa')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }


    /**
     * Upload qa files for a project drawing
     *
     * @param $id
     * @return string
     */
    public function drawings_qa_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/quality-control/drawings/' . $input['id'])) {
                Storage::makeDirectory('projects/' . $id . '/quality-control/drawings/' . $input['id']);
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/quality-control/drawings/' . $input['id'] .'/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/quality-control/drawings/' . $input['id'] .'/' . $filename, File::get($file));


            //add drawings to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/quality-control/drawings/' . $input['id'] .'/' . $filename]);

            if (ProjectQualityControlDrawing::where('project_id', $id)->where('drawing_id', $input['id'])->whereNull('file_id')->count() > 0) {
                $qa_drawing = ProjectQualityControlDrawing::where('project_id', $id)->where('drawing_id', $input['id'])->whereNull('file_id')->first();
                $qa_drawing->file_id = $new_file->id;
                $qa_drawing->save();
            }
            else {
                $project->quality_control_drawings()->save(new ProjectQualityControlDrawing([
                    'drawing_id' => $input['id'],
                    'file_id' => $new_file->id
                ]));
            }

        }
        return 'true';

    }

    /**
     * Multiple remove of qa files from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function drawings_qa_file_destroy(Request $request, $id) {
        $req = $request->all();


        if (isset($req['id'])) {
            $qa_drawing = ProjectQualityControlDrawing::findOrFail($req['id']);
            $file = \App\Models\File::findOrfail($qa_drawing->file_id);

            // Delete files if has any
            if (Storage::exists($file->file)) {
                Storage::delete([$file->file]);
            }

            if (ProjectQualityControlDrawing::where('project_id', $id)->where('drawing_id', $qa_drawing->drawing_id)->count() > 1) {
                $qa_drawing->delete();
            }
            else {
                $qa_drawing->file_id = null;
                $qa_drawing->save();
            }
            $file->delete();


            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@drawings_qa', $id);

    }

    /**
     * Download qa files
     *
     * @param Request $request
     * @param $id
     */
    public function drawings_qa_download_templates(Request $request, $id) {

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'select_') !== false && $key != 'select_all') {
                $drawing_id = $value;


            }
        }
    }


    /**
     * Display drawings register page
     *
     * @param $id
     * @return mixed
     */
    public function drawings_register($id)
    {
        if (!hasPermission('Projects - Drawings register')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.drawings_register')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'))->with('colors', Config::get('color.user_colors'));
    }

    /**
     * Update the drawings register of specified project in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function drawings_register_update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($request->has('drawing_id')) {
            $register_item = ProjectDrawingsRegister::where('drawing_id', $request->input('drawing_id'))->where('project_id', $id)->first();

            $req = $request->all();

            $req[$request->input('type') . '_date'] = Carbon::now();
            $req[$request->input('type') . '_user_id'] = Auth::id();

            if (!is_null($register_item)) {
                $register_item->update($req);
            }
            else {
                $req['project_id'] = $id;
                $req['drawing_id'] = $request->input('drawing_id');
                ProjectDrawingsRegister::create($req);
            }
        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@drawings_register', $id);
    }

    /**
     * Display a listing of the invoices.
     *
     * @param $id
     * @return $this
     */
    public function invoices($id)
    {
        if (!hasPermission('Projects - invoices list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.invoices')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload invoices files for a project
     *
     * @param $id
     * @return string
     */
    public function invoices_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            if (!Storage::exists('projects/' . $id . '/invoices')) {
                Storage::makeDirectory('projects/' . $id . '/invoices');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/invoices/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/invoices/' . $filename, File::get($file));


            //add invoices to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/invoices/' . $filename]);

            $project->invoices()->save(new ProjectInvoice([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of invoices from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function invoices_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $invoice_id) {

                $invoice = ProjectInvoice::findOrFail($invoice_id);
                $file = \App\Models\File::findOrfail($invoice->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $invoice->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@invoices', $id);

    }


    public function getMaterials($id)
    {
        $project = Project::findOrFail($id);

        return view('projects.materials')->with('project', $project);
    }


    /**
     * Display a listing of the requests for quotation.
     *
     * @param $id
     * @return $this
     */
    public function rfq($id)
    {
        if (!hasPermission('Projects - RFQ list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.rfq')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload rfq files for a project
     *
     * @param $id
     * @return string
     */
    public function rfq_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/RFQ')) {
                Storage::makeDirectory('projects/' . $id . '/RFQ');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/RFQ/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/RFQ/' . $filename, File::get($file));


            //add rfq to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/RFQ/' . $filename]);

            $project->rfq()->save(new ProjectRFQ([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of rfq files from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function rfq_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $rfq_id) {

                $rfq = ProjectRFQ::findOrFail($rfq_id);
                $file = \App\Models\File::findOrfail($rfq->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $rfq->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@rfq', $id);

    }

    /**
     * Display a listing of the order confirmations.
     *
     * @param $id
     * @return $this
     */
    public function order_confirmations($id)
    {
        if (!hasPermission('Projects - Order confirmations list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.order_confirmations')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload order confirmations files for a project
     *
     * @param $id
     * @return string
     */
    public function order_confirmations_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/order_confirmations')) {
                Storage::makeDirectory('projects/' . $id . '/order_confirmations');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/order_confirmations/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/order_confirmations/' . $filename, File::get($file));


            //add rfq to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/order_confirmations/' . $filename]);

            $project->order_confirmations()->save(new ProjectOrderConfirmation([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

            //log
            loggr(trans('log.:user a încărcat documentul :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => '<a href="' . action('FilesController@show', ['id' => $new_file->id, 'name' => $filename]) . '" target="_blank">' . $filename . '</a>']), Auth::id(), '{"entity_type": "' . get_class($project) . '", "entity_id": ' . $new_file->id . '}');

        }
        return 'true';
    }

    /**
     * Multiple destroy of order confirmations files from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function order_confirmations_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        $filenames = '';
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $rfq_id) {

                $project_order_confirmations = ProjectOrderConfirmation::findOrFail($rfq_id);
                $file = \App\Models\File::findOrfail($project_order_confirmations->file->id);

                $name = explode('/', $file->file);
                $filenames .= array_pop($name) . ', ';

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $project_order_confirmations->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));

            $filenames = preg_replace('/,\s$/', '', $filenames);

            //log
            loggr(trans('log.:user a șters documentele :document', ['user' => '<a href="' . action('UsersController@edit', Auth::id()) . '" target="_blank">' . Auth::user()->name() . '</a>', 'document' => $filenames]), Auth::id(), '{"entity_type": "' . Project::class . '", "entity_id": ' . json_encode($req['remove']) . '}');
        }

        return redirect()->action('ProjectsController@order_confirmations', $id);

    }

    /**
     * Display the GANTT chart for a project
     *
     * @param $id
     * @return $this
     */
    public function terms($id)
    {
        $project = Project::findOrFail($id);

        return view('projects.terms')->with('project', $project)->with('gantt_start_date', GanttTask::where('project_id', $id)->min('start_date'))->with('legal_holidays', Config::get('legal_holidays.dates'));
    }

    /**
     * Display the GANTT chart for all projects
     *
     * @return $this
     * @internal param $id
     */
    public function gantt()
    {
        return view('projects.gantt')->with('gantt_start_date', GanttTask::min('start_date'))->with('gantt_end_date', max(GanttTask::max('end_date'), Carbon::now()->addYear()))->with('projects', Project::where('type', 'work')->get())->with('legal_holidays', Config::get('legal_holidays.dates'));
    }

    /**
     * Generate QR code labels
     *
     * @param $id
     * @return mixed
     */
    public function qr_label($id) {

        $project = Project::findOrFail($id);

        config(['dompdf.defines.DOMPDF_DPI' => 300]);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('pdf.qr_label', ['project' => $project]);
        $pdf->setPaper(array(0,0,55,181));

        return $pdf->stream();

        /*return view('pdf.qr_label')->with([
            'project' => $project
        ]);*/
    }




    /**
     * Display a listing of the transport files.
     *
     * @param $id
     * @return $this
     */
    public function transport($id)
    {
        if (!hasPermission('Projects - Transport files')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.transport')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload transport files for a project
     *
     * @param $id
     * @return string
     */
    public function transport_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            if (!Storage::exists('projects/' . $id . '/transport')) {
                Storage::makeDirectory('projects/' . $id . '/transport');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/transport/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/transport/' . $filename, File::get($file));


            //add transport files to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/transport/' . $filename]);

            $project->transport_files()->save(new ProjectTransport([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of transport files from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function transport_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $transport_id) {

                $transport = ProjectTransport::findOrFail($transport_id);
                $file = \App\Models\File::findOrfail($transport->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $transport->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@transport', $id);

    }

    /**
     * Display a listing of the packing list files.
     *
     * @param $id
     * @return $this
     */
    public function packing_list($id)
    {
        if (!hasPermission('Projects - Packing list files')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.packing_list')->with('project', $project);
    }

    /**
     * Display a the packing list pdf file.
     *
     * @param $id
     * @param $term_id
     * @return $this
     */
    public function packing_list_pdf($id, $term_id)
    {
        if (!hasPermission('Projects - Packing list files')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('pdf.packing_list', ['project' => $project, 'term_id' => $term_id]);
        $pdf->setPaper('a4');

        return $pdf->stream('packing-list.pdf');
    }

    /**
     * Display a listing of the mails.
     *
     * @param $id
     * @return $this
     */
    public function mails($id)
    {
        if (!hasPermission('Projects - Mails list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.mails.index')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload mails files for a project
     *
     * @param $id
     * @return string
     */
    public function mails_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/mails')) {
                Storage::makeDirectory('projects/' . $id . '/mails');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/mails/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/mails/' . $filename, File::get($file));


            //add mails to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/mails/' . $filename]);

            $project->mails()->save(new ProjectMail([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of mails from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function mails_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $mail_id) {

                $mail = ProjectMail::findOrFail($mail_id);
                $file = \App\Models\File::findOrfail($mail->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $mail->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@mails', $id);

    }

    /**
     * Display a listing of the photos.
     *
     * @param $id
     * @return $this
     */
    public function photos($id)
    {
        if (!hasPermission('Projects - Photos list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);

        return view('projects.photos.index')->with('project', $project)->with('file_type_colors', Config::get('color.file_type_colors'));
    }

    /**
     * Upload photos files for a project
     *
     * @param $id
     * @return string
     */
    public function photos_upload($id)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/photos')) {
                Storage::makeDirectory('projects/' . $id . '/photos');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/photos/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/photos/' . $filename, File::get($file));


            //add photos to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/photos/' . $filename]);

            $project->photos()->save(new ProjectPhoto([
                'name' => $filename,
                'file_id' => $new_file->id
            ]));

        }
        return 'true';
    }

    /**
     * Multiple destroy of photos from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function photos_multiple_destroy(Request $request, $id)
    {
        $req = $request->all();
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $photo_id) {

                $photo = ProjectPhoto::findOrFail($photo_id);
                $file = \App\Models\File::findOrfail($photo->file->id);

                // Delete files if has any
                if (Storage::exists($file->file)) {
                    Storage::delete([$file->file]);
                }

                $photo->delete();
                $file->delete();
            }

            Session::flash('success_msg', trans('Înregistrările au fost șterse cu succes'));
        }

        return redirect()->action('ProjectsController@photos', $id);

    }


    /**
     * Display a listing of the documents.
     *
     * @param $id
     * @param $document_category
     * @return $this
     */
    public function documents($id, $document_category)
    {
        $category = ProjectDocumentCategory::findOrFail($document_category);
        $sibling_categories = ProjectDocumentCategory::where('type', $category->type)->get();
        $project_offers = ProjectOffer::where('project_id', $id)->get();

        $offers = [];

        foreach ($project_offers as $project_offer) {
            $file = $project_offer->ctcFile;
            if (!is_null($file)) {
                $file_name = explode('/', $file->file);
                $file->name = array_pop($file_name);
                $offers[] = $file;
            }
        }

        if (!hasPermission('Projects - ' . ucfirst($category->type) . ' documents list')) {
            abort(401);
        }

        $project = Project::findOrFail($id);
        $documents = ProjectDocument::where('project_id', $id)->where('category_id', $category->id)->orderBy('name', 'ASC')->get();

        return view('projects.documents.index')->with('project', $project)->with('documents', $documents)->with('category', $category)->with('sibling_categories', $sibling_categories)->with('file_type_colors', Config::get('color.file_type_colors'))->with('offers', $offers);
    }

    /**
     * Upload documents files for a project
     *
     * @param $id
     * @param $document_category
     * @return string
     */
    public function documents_upload($id, $document_category)
    {
        $project = Project::findOrFail($id);
        $input = Input::all();

        if (isset($input['file'])) {

            $file = $input['file'];

            //check if the folder exist (if the folder does not exist, create it)
            if (!Storage::exists('projects/' . $id . '/documents')) {
                Storage::makeDirectory('projects/' . $id . '/documents');
            }

            //check if a file exists with the same name
            $filename = $file->getClientOriginalName();
            $i = 1;
            while (Storage::exists('projects/' . $id . '/documents/' . $filename)) {
                $filename = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . '-' .$i . '.' . $file->getClientOriginalExtension();
                $i++;
            }

            //copy file
            Storage::put('projects/' . $id . '/documents/' . $filename, File::get($file));


            //add documents to db
            $new_file = \App\Models\File::create(['file' => 'projects/' . $id . '/documents/' . $filename]);

            $project->documents()->save(new ProjectDocument([
                'name' => $filename,
                'file_id' => $new_file->id,
                'category_id' => $document_category
            ]));

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
        $category = 0;
        if (count($req['remove']) > 0) {
            foreach ($req['remove'] as $document_id) {

                $document = ProjectDocument::findOrFail($document_id);
                $category = $document->category_id;
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

        return redirect()->action('ProjectsController@documents', [$id, $category]);

    }

    public function temp($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.temp')->with('project', $project);
    }

    /**
     * Change the status of folder
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function change_folder_status(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $req = $request->all();

        $folder_status = ProjectFoldersStatus::firstOrCreate(['project_id' => $id, 'folder_id' => $req['folder_id'], 'user_id' => Auth::id()]);
        $folder_status->status = $req['status'];
        $folder_status->description = isset($req['description']) ? $req['description'] : null;
        $folder_status->save();

        //Notification
        $folder = ProjectFolder::find($req['folder_id']);
        if ($req['status'] == 'completed' && $folder->route_name == 'projects.datasheet') {
            NotificationType::send('Projects - Datasheet finished', trans('notifications.<b>:user</b> a setat foaia de date ca și terminat în cazul proiectului: <b>:project</b>', ['user' => Auth::user()->name(), 'project' => $project->production_name() . ' ' . $project->customer->short_name . ' ' . $project->name]), action('ProjectsController@datasheet', $project->id));
        }

        Session::flash('success_msg', trans('Schimbarea statusului a fost salvată cu succes'));

        return redirect($req['return_url']);
    }


    public function cad_viewer($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.cad_viewer.index')->with('project', $project);
    }

    public function requirements_analysis($id)
    {
        if (!hasPermission('Requirements analysis view'))
        {
            abort(401);
        }

        $project = Project::findOrFail($id);
        $items = ProjectRequirementsAnalysisItem::all();

        // roles
        $roles['Tehnolog'] = !is_null($role = Role::where('name', 'Tehnolog')->first()) ? $role->id : 0;
        $roles['IWE'] = !is_null($role = Role::where('name', 'IWE')->first()) ? $role->id : 0;
        $roles['Aprovizionare'] = !is_null($role = Role::where('name', 'Responsabil Aprovizionare')->first()) ? $role->id : 0;
        $roles['Șef CTC'] = !is_null($role = Role::where('name', 'Șef CTC')->first()) ? $role->id : 0;
        $roles['Magazioner'] = !is_null($role = Role::where('name', 'Magazioner')->first()) ? $role->id : 0;
        $roles['Director Producție'] = !is_null($role = Role::where('name', 'Director Producție')->first()) ? $role->id : 0;
        $roles['Responsabil Transport'] = !is_null($role = Role::where('name', 'Responsabil Transport')->first()) ? $role->id : 0;
        $roles['Șef Echipă Montatori'] = !is_null($role = Role::where('name', 'Șef Echipă Montatori')->first()) ? $role->id : 0;

        // users by role & by requirements analysis items
        $users_by_role['Tehnolog'] = [];
        $users_by_item['Tehnolog'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Tehnolog'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Tehnolog'])) {
                $users_by_role['Tehnolog'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Tehnolog'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Tehnolog'][$ra_item->item_id])) {
                $users_by_item['Tehnolog'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['IWE'] = [];
        $users_by_item['IWE'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['IWE'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['IWE'])) {
                $users_by_role['IWE'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['IWE'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['IWE'][$ra_item->item_id])) {
                $users_by_item['IWE'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Aprovizionare'] = [];
        $users_by_item['Aprovizionare'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Aprovizionare'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Aprovizionare'])) {
                $users_by_role['Aprovizionare'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Aprovizionare'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Aprovizionare'][$ra_item->item_id])) {
                $users_by_item['Aprovizionare'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Șef CTC'] = [];
        $users_by_item['Șef CTC'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Șef CTC'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Șef CTC'])) {
                $users_by_role['Șef CTC'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Șef CTC'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Șef CTC'][$ra_item->item_id])) {
                $users_by_item['Șef CTC'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Magazioner'] = [];
        $users_by_item['Magazioner'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Magazioner'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Magazioner'])) {
                $users_by_role['Magazioner'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Magazioner'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Magazioner'][$ra_item->item_id])) {
                $users_by_item['Magazioner'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Director Producție'] = [];
        $users_by_item['Director Producție'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Director Producție'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Director Producție'])) {
                $users_by_role['Director Producție'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Director Producție'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Director Producție'][$ra_item->item_id])) {
                $users_by_item['Director Producție'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Responsabil Transport'] = [];
        $users_by_item['Responsabil Transport'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Responsabil Transport'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Responsabil Transport'])) {
                $users_by_role['Responsabil Transport'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Responsabil Transport'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Responsabil Transport'][$ra_item->item_id])) {
                $users_by_item['Responsabil Transport'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }

        $users_by_role['Șef Echipă Montatori'] = [];
        $users_by_item['Șef Echipă Montatori'] = [];
        $ra_items = $project->requirements_analysis()->where('role_id', $roles['Șef Echipă Montatori'])->get();
        foreach ($ra_items as $ra_item) {
            if (!in_array($ra_item->user->name(), $users_by_role['Șef Echipă Montatori'])) {
                $users_by_role['Șef Echipă Montatori'][] = $ra_item->user->name();
            }
            if (!isset($users_by_item['Șef Echipă Montatori'][$ra_item->item_id]) || !in_array($ra_item->user->name(), $users_by_item['Șef Echipă Montatori'][$ra_item->item_id])) {
                $users_by_item['Șef Echipă Montatori'][$ra_item->item_id][] = $ra_item->user->name();
            }
        }


        return view('projects.requirements_analysis.index')->with([
            'config' => Config::get('requirements_analysis'),
            'items' => $items,
            'project' => $project,
            'roles' => $roles,
            'role_colors' => Config::get('color.user_roles_colors'),
            'users_by_item' => $users_by_item,
            'users_by_role' => $users_by_role
        ]);
    }

    /**
     * Update the requirements analysis of specified project in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requirements_analysis_update(Request $request, $id)
    {
        $project = Project::findOrFail($id);


        if ($request->has('item')) {
            ProjectRequirementsAnalysis::create(['project_id' => $id, 'item_id' => $request->input('item'), 'date' => Carbon::now(), 'status' => 1, 'user_id' => Auth::id(), 'role_id' => $request->input('role')]);
        }
        else {
            $items = ProjectRequirementsAnalysisItem::all();
            foreach ($items as $item) {
                if ($item->id != 11 /*no assembling*/ || ($item->id == 11 && $project->has_assembling())) {
                    ProjectRequirementsAnalysis::create(['project_id' => $id, 'item_id' => $item->id, 'date' => Carbon::now(), 'status' => 1, 'user_id' => Auth::id(), 'role_id' => $request->input('role')]);
                }
            }

        }

        Session::flash('success_msg', trans('Modificările au fost salvate cu succes'));

        return redirect()->action('ProjectsController@requirements_analysis', $id);
    }
}
