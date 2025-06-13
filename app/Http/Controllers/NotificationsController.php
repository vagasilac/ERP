<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use C4studio\Notification\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class NotificationsController extends Controller
{
    private $items_per_page;

    public function __construct()
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

    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Carbon::setLocale('ro');

        $notifications_obj = Auth::user()->notifications();

        //Filters
        if ($request->has('search') && $request->input('search') != '') {
            $notifications_obj = $notifications_obj->where('message', 'LIKE', '%' . $request->input('search') . '%');
        }

        //Sort
        $notifications_obj = $notifications_obj->orderBy('timestamp', 'desc');

        if ($request->ajax()) {
            $view = view('notifications._notifications_list');
        }
        else {
            $view = view('notifications.index');
        }


        $view = $view->with('notifications', $notifications_obj->paginate($this->items_per_page));

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    public function mark_read(Notification $notification)
    {
        $notification->markRead();
    }
}
