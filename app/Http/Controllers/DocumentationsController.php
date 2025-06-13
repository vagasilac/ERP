<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Models\Documentation;
use App\Models\DocumentationChild;
use App\Models\Process;
use App\Models\Standard;
use Carbon\Carbon;

class DocumentationsController extends Controller
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
        $documentations = Documentation::all();

        return view('documentations.index')->with('documentations', $documentations);
    }

    public function pdf_viewer($id, $type)
    {
        if ($type == 'main') {
            $documentation = Documentation::findOrFail($id);
            $name = $documentation->name;
            $url = $documentation->link;
        }
        else {
            $documentation = DocumentationChild::findOrFail($id);
            $name = $documentation->name;
            $url = $documentation->link;
        }

        return view('documentations.pdf_viewer')->with([
            'name' => $name,
            'url' => asset($url)
        ]);
    }

    public function anexa_a()
    {
        $processes = Process::all();
        $standards = Standard::all();

        return view('documentations.anexa_a')->with('processes', $processes)->with('standards', $standards);
    }

}
