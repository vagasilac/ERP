<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Download the specified file from storage
     *
     * @param $id
     * @param null $name
     * @return mixed
     */
    public function show($id, $name = null) {
        $file = \App\Models\File::findOrFail($id);

        return response()->file(storage_path('app') . '/' . $file->file);
        //return Response::download(storage_path('app') . '/' . $file->file, $name != null ? $name : '');

        /*$path = storage_path('app') . '/' . $file->file;

        if (!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;*/
    }

    /**
     * Return the specified image
     *
     * @param $path
     * @return mixed
     */
    public function image($path) {
        $path = storage_path('app') . '/' . base64_decode($path);


        if (!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
