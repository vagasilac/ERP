<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class ComplaintsController extends Controller
{
    /**
     * List of complaints
     *
     * @return mixed
     */
    public function index()
    {
        return view('complaints.index')->with([
            'colors' => \Config::get('color.user_colors'),
            'items' => [
                (object) [
                    'id' => '2016-1',
                    'date' => Carbon::create(2016, 02, 11),
                    'customer' => Customer::find(9),
                    'related_project' => '200PF',
                    'description' => 'Diferenta de livrare (-10 buc)',
                    'solution' => 'Fabricare, livrarea reperele lipse.',
                    'status_reasoned' => 1,
                    'status_unreasoned' => 0,
                    'claim' => 0,
                    'acp_no' => '',
                    'person_takeover' => User::find(77)
                ],
                (object) [
                    'id' => '2016-2',
                    'date' => Carbon::create(2016, 10, 24),
                    'customer' => Customer::find(9),
                    'related_project' => '304PF',
                    'description' => 'Diferenta de livrare (-20 buc)',
                    'solution' => 'Fabricare, livrarea reperele lipse.',
                    'status_reasoned' => 1,
                    'status_unreasoned' => 0,
                    'claim' => 0,
                    'acp_no' => '',
                    'person_takeover' => User::find(77)
                ],
                (object) [
                    'id' => '2016-3',
                    'date' => Carbon::create(2016, 11, 17),
                    'customer' => Customer::find(9),
                    'related_project' => '311PF',
                    'description' => 'Probleme cu gauri.',
                    'solution' => 'Reproducerea pieselor neconforme.',
                    'status_reasoned' => 1,
                    'status_unreasoned' => 0,
                    'claim' => 0,
                    'acp_no' => '2016-2',
                    'person_takeover' => User::find(77)
                ],
                (object) [
                    'id' => '2016-4',
                    'date' => Carbon::create(2016, 12, 15),
                    'customer' => Customer::find(9),
                    'related_project' => '321PF',
                    'description' => 'Diferenta de livrare (+10 buc)',
                    'solution' => 'Corectarea cantităților la următoarea livrare (10 buc. mai putin).',
                    'status_reasoned' => 1,
                    'status_unreasoned' => 0,
                    'claim' => 0,
                    'acp_no' => '',
                    'person_takeover' => User::find(77)
                ],
                (object) [
                    'id' => '2017-1',
                    'date' => Carbon::create(2017, 05, 04),
                    'customer' => Customer::find(9),
                    'related_project' => '372PF',
                    'description' => 'Diferenta de livrare (+10 buc)',
                    'solution' => 'Corectarea cantităților la următoarea livrare (10 buc. mai putin).',
                    'status_reasoned' => 1,
                    'status_unreasoned' => 0,
                    'claim' => 0,
                    'acp_no' => 'ID-1',
                    'person_takeover' => User::find(25)
                ],
            ]
        ]);
    }
}
