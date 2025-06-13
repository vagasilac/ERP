<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Models\ProjectDocument;

class DocumentsQcController extends Controller
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
        $documents = ProjectDocument::whereIn('category_id', function($query) {
            $query->select('id')->from('project_document_categories')->where('type', 'qc');
        })->orderBy('project_id')->get();

        return view('documents_qc.index')->with('documents', $documents);
    }
}
