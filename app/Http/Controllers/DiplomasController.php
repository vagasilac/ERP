<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Models\UserDocument;

class DiplomasController extends Controller
{
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
        $diplomas = UserDocument::where('type', 'diploma')->get();

        return view('diplomas.index')->with('diplomas', $diplomas)->with('colors', Config::get('color.user_colors'));
    }
}
