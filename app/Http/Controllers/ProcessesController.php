<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Process;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class ProcessesController extends Controller
{
    /**
     * Return Processes list
     *
     * @return mixed
     */
    public function get_processes() {
        $term = Input::get('q');

        $process_obj = Process::where('id', '>', 0);

        //Filters
        if ($term != '') {
            $process_obj = $process_obj->where('name' , 'LIKE', '%' . $term . '%');
        }

        $precesses = $process_obj->get();


        return $precesses;
    }
}
