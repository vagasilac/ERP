<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;

class CertificatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id, $lang)
    {
        if (is_array(Config::get('certificates.pdfs.' . $id))) {
            $url_ro = asset(Config::get('certificates.pdfs.' . $id . '.ro'));
            $url_hu = asset(Config::get('certificates.pdfs.' . $id . '.hu'));
            $url_en = asset(Config::get('certificates.pdfs.' . $id . '.en'));
        }
        else {
            $url_ro = asset(Config::get('certificates.pdfs.' . $id));
            $url_hu = null;
            $url_en = null;
        }

        return view('certificates.index')->with([
            'url_ro' => $url_ro,
            'url_hu' => $url_hu,
            'url_en' => $url_en,
            'lang' => $lang,
            'id' => $id
        ]);
    }
}
