<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class DownloadsController extends Controller
{
    public function show($id) {
        return 'This page will download a file from storage';
    }
}
