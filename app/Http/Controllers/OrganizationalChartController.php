<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineDocument;
use App\Models\OrganizationalChartItem;
use App\Models\ProjectCalculationsSetting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OrganizationalChartController extends Controller
{
    var $items_per_page;

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
     * Display a listing of the machines.
     */
    public function index()
    {
        if (!hasPermission('Machines list')) {
            abort(401);
        }

        return view('ims.organizational_chart.index')->with([
            'role_colors' => Config::get('color.user_roles_colors')
        ]);
    }
}
