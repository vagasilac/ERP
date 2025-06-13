<?php

namespace App\ViewComposers;

use App\Models\Message;
use App\Models\MessageParticipant;
use App\Models\MessageRead;
use App\Models\MessageRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ViewComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        if(Auth::user()){

            //Messages rooms and unread messages
            $user = Auth::user();
            $participants = MessageParticipant::select('message_room_id')->where('user_id', $user->id)->get();


            $rooms = MessageRoom::whereIn('id', $participants)->with(['participants'=>function($query) use($user){
                $query->where('user_id', '!=', $user->id);
            }])->orderBy('updated_at', 'DESC')->limit(5)->get();

            $unreadMessages = MessageRead::where('user_id', $user->id)->count();

            //Notifications
            $readNotifications= Auth::user()->notifications()->join('notifications_read', function($join) {
                $join->on('notifications.id', '=', 'notifications_read.notification_id')->where('notifications_read.user_id', '=', Auth::id());
            })->count();

            $unreadNotifications = Auth::user()->notifications()->count() - $readNotifications;
        }
        else{
            $rooms = collect([]);
            $unreadMessages = 0;
            $unreadNotifications = 0;
        }

        $view->with('userRooms', $rooms)->with('unreadMessages', $unreadMessages)->with('unreadNotifications', $unreadNotifications);
    }
}