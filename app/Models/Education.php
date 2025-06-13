<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Participant;
use App\Models\UserDocument;

class Education extends Model
{
    protected $fillable = ['nr', 'description', 'role_id', 'supplier_id', 'planned_start_date', 'planned_finish_date', 'accomplished_start_date', 'accomplished_finish_date', 'trainer_confirmed', 'rating_mode', 'repeat', 'certificate_id', 'certificate_nr'];

    /**
     * Get Supplier.
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }

    /*
    * Get role.
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    /*
    * Get certificate.
     */
    public function certificate()
    {
        return $this->belongsTo('App\Models\UserDocument');
    }

    /*
    * Get participant.
     */
    public function participant()
    {
        return $this->hasMany('App\Models\Participant', 'education_id');
    }

    /*
    * Get planned duration.
     */
    public function get_planned_duration()
    {
        $planned_finish_date = Carbon::parse($this->planned_finish_date);
        $planned_start_date = Carbon::parse($this->planned_start_date);

        return $planned_finish_date->diffInDays($planned_start_date) + 1;
    }

    /*
    * Get accomplished duration.
     */
    public function get_accomplished_duration()
    {
        $accomplished_finish_date = Carbon::parse($this->accomplished_finish_date);
        $accomplished_start_date = Carbon::parse($this->accomplished_start_date);

        return $accomplished_finish_date->diffInDays($accomplished_start_date) + 1;
    }

    /*
    * Get user confirmed rating
     */
    public function get_user_confirmed_rating()
    {
        $total = $this->participant()->select(DB::raw('COUNT(DISTINCT user_id) as total'))->first();
        $confirmed = $this->participant()->select(DB::raw('COUNT(DISTINCT user_id) as confirmed'))->where('user_confirmed', '1')->first();

        return $confirmed->confirmed . '/' . $total->total;
    }

    /*
    * Verify is a user confrmed.
     */
    public function user_confirmed($id)
    {
        $query = $this->participant()->select('user_confirmed')->where('education_id', $this->id)->where('user_id', $id)->first();

        if ($query->user_confirmed == 0) {
            return false;
        }
        else {
            return true;
        }
    }

    /*
    * Return participants names.
     */
    public function get_participants_name()
    {
        $list = '';
        $participants = $this->participant;

        foreach ($participants as $participant) {
            $list .= $participant->user->name() . ', ';
        }

        $list = preg_replace('/,\s$/', '', $list);

        return $list;
    }

    /*
    * Return participant's user model
     */
    public function get_participant_users()
    {
        $users = [];
        foreach ($this->participant as $participant) {
            $users[] = $participant->user;
        }

        return $users;
    }

    /*
    * Verify is all user assigned.
     */
    public function is_all_user()
    {
        $count_all_users = count(User::all());
        $count_participants = count($this->participant);

        if ($count_all_users == $count_participants) {
            return true;
        }
        else {
            return false;
        }
    }
}
