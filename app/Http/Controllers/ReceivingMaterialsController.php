<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Models\TmpReceivingMaterial;

class ReceivingMaterialsController extends Controller
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

    public function index()
    {
        $materials = TmpReceivingMaterial::all();

        return view('receiving_materials.index')->with('materials', $materials);
    }
}
