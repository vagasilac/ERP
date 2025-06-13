<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;

class ReferenceStandardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index($id, $lang)
    {
        if (is_array(Config::get('reference_standards.pdfs.' . $id))) {
            $url_ro = asset(Config::get('reference_standards.pdfs.' . $id . '.ro'));
            $url_other = asset(Config::get('reference_standards.pdfs.' . $id . '.en'));
        }
        else {
            $url_ro = asset(Config::get('reference_standards.pdfs.' . $id));
            $url_other = null;
        }

        return view('reference_standards.index')->with(['url_ro' => $url_ro, 'url_other' => $url_other, 'id' => $id, 'lang' => $lang]);
    }
}
