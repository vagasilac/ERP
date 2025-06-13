<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    protected $source = [
        ['id' => 1, 'name' => 'Varianta 1'],
        ['id' => 2, 'name' => 'Varianta 2'],
        ['id' => 3, 'name' => 'Varianta 3'],
        ['id' => 4, 'name' => 'Varianta 4'],
        ['id' => 5, 'name' => 'Varianta 5'],
    ];

    public function getDemo() {
        $term = Input::get('q');

        $result = array_where($this->source, function($key, $value) use ($term) {
            return $term ? (strpos($value['name'], $term) !== false) : 1;
        });

        if (!empty($result))
            return json_encode([
                'code' => 200,
                'result' => $result
            ]);
        else
            return json_encode([
                'code' => 204,
                'result' => null
            ]);
    }
}
