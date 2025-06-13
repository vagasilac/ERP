<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageParticipant;
use App\Models\MessageRead;
use App\Models\MessageRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class MessagesController extends Controller
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
     * List rooms and messages
     * @param Request $request
     * @param bool $room
     * @return View
     */
    public function index(Request $request, $room = false) {
        $user = Auth::user();

        $participants = MessageParticipant::select('message_room_id')->where('user_id', $user->id)->get();

        $rooms = MessageRoom::whereIn('id', $participants)->with(['participants'=>function($query) use($user){
            $query->where('user_id', '!=', $user->id);
        }])->orderBy('updated_at', 'DESC')->paginate($this->items_per_page);

        if($room !== false){
            $activeRoom = MessageRoom::whereIn('id', $participants)->with(['participants'=>function($query) use($user){
                $query->where('user_id', '!=', $user->id);
            }])->where('id', $room)->first();
            if(is_null($activeRoom)) $activeRoom = $rooms->first();
        }
        else{
            $activeRoom = $rooms->first();
        }

        if(!is_null($activeRoom))
            MessageRead::where('message_room_id', $activeRoom->id)->where('user_id', Auth::user()->id)->delete();

        if ($request->ajax()) {
            $view = view('messages._rooms');
        }
        else {
            $view = view('messages.index');
        }

        $view = $view->with('users', User::all())
            ->with('colors', Config::get('color.user_colors'))
            ->with('rooms', $rooms)
            ->with('activeRoom', $activeRoom);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }

    }

    /**
     * Get messages with ajax
     * @param Request $request
     * @param $room Room id
     * @return boolean/html
     */
    public function messages(Request $request, $room){

        $user = Auth::user();

        $participants = MessageParticipant::select('message_room_id')->where('user_id', $user->id)->get();

        if($room !== false){
            $activeRoom = MessageRoom::whereIn('id', $participants)->with(['participants'=>function($query) use($user){
                $query->where('user_id', '!=', $user->id);
            }])->where('id', $room)->first();
            if(is_null($activeRoom)) $activeRoom = MessageRoom::all()->first();
        }
        else return false;

        if(!is_null($activeRoom)){
            MessageRead::where('message_room_id', $activeRoom->id)->where('user_id', Auth::user()->id)->delete();
        }

        if ($request->ajax()) {
            $view = view('messages._messages');
        }
        else {
            $view = view('messages.index');
        }

        $view = $view->with('users', User::all())
            ->with('colors', Config::get('color.user_colors'))
            ->with('activeRoom', $activeRoom);

        if ($request->ajax()) {
            return $view->render();
        }
        else {
            return $view;
        }
    }

    /**
     * Store message
     * @param Request $request
     * @return bool
     */
    public function store(Request $request){
        if($request->ajax()){
            $user = Auth::user();
            $data = Input::only('message', 'room_id', 'participants');

            // create new room
            if($data['room_id'] == 0){
                $p = $data['participants'];
                $p[] = Auth::user()->id;
                $same_participants_rooms = MessageRoom::whereHas('participants', function($q) use($p){
                    $q->whereIn('user_id', $p);
                })->get();

                $same_participants_room = false;

                foreach($same_participants_rooms as $sr){
                    $other_participant_found = false;
                    if($sr->participants->count() == sizeof($p)){
                        foreach($sr->participants as $test_participant){
                            if(!in_array($test_participant->user_id, $p)) $other_participant_found = true;
                        }
                        if($other_participant_found == false) {
                            $same_participants_room = $sr;
                            break;
                        }
                    }
                    else{
                        continue;
                    }
                }
                if($same_participants_room){
                    $room = $same_participants_room;
                }
                else{
                    $room = MessageRoom::create(['name' => '']);
                    foreach($data['participants'] as $participant){
                        MessageParticipant::create([
                            'message_room_id' => $room->id,
                            'user_id' => $participant
                        ]);
                    }
                    MessageParticipant::create([
                        'message_room_id' => $room->id,
                        'user_id' => $user->id
                    ]);
                }
            }
            else{
                $room = MessageRoom::find($data['room_id']);
            }

            if($room && !is_null(MessageParticipant::where('message_room_id', $room->id)->where('user_id', $user->id)->first())){
                $message = Message::create([
                    'user_id' => $user->id,
                    'message_room_id' => $room->id,
                    'message' => $data['message']
                ]);

                $room->updated_at = date('Y-m-d H:i:s');
                $room->save();

                $roomId = $room->id;

                $participants = MessageParticipant::where('message_room_id', $room->id)->where('user_id', '!=', $user->id)->get();

                foreach($participants as $participant){
                    MessageRead::create([
                        'message_id' => $message->id,
                        'user_id' => $participant->user_id,
                        'message_room_id' => $roomId
                    ]);
                }

                $view = view('messages._message');

                $view = $view->with('users', User::all())
                    ->with('colors', Config::get('color.user_colors'))
                    ->with('message', $message)
                    ->with('activeRoom', $room);

                if($data['room_id'] != 0)
                    return $view->render();
                else
                    return $room->id;
            }
            // room not found
            else return 0;
        }
    }

    /**
     * Add new participant
     * @param Request $request
     * @return mixed
     */
    public function add_participant(Request $request){
        if($request->ajax()){
            $data = Input::only('id');

            $user = User::find($data['id']);

            if($user){
                $view = view('messages._participants');

                $view = $view->with('user', $user);

                return $view->render();
            }
        }
    }

    /**
     * Live search users as participants
     * @param Request $request
     * @return int
     */
    public function get_participants(Request $request){
        if($request->ajax()) {
            $user = Auth::user();

            $data = Input::only('s', 'participants');

            if(empty($data['s'])) return 0;

            // create query for participants
            $participants_q = '';

            if(!isset($data['participants'])) $participants_q = '';
            else{
                $participants_q = ' AND id NOT IN (';
                foreach($data['participants'] as $p){
                    if(end($data['participants']) != $p)
                        $participants_q .= $p . ',';
                    else
                        $participants_q .= $p;
                }
                $participants_q .= ')';
            }

            $users = User::whereRaw('id != '.$user->id.' AND (firstname LIKE "%'.$data['s'].'%" OR lastname LIKE "%'.$data['s'].'%")'.$participants_q)->get();

            $view = view('messages._participant_list');

            $view = $view->with('users', $users);

            return $view->render();
        }

    }
}
