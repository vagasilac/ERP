<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $fillable =  ['name', 'label', 'order'];

    /**
     * A notification type can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public static function send($type, $message =  null, $action = null) {
        if (!is_null($message) && !is_null($action)) $message = '<a href="' . $action . '">' . $message . '</a>';

        $notification_type = NotificationType::where('name', $type)->first();

        $users_temp = [];
        if (!is_null($notification_type) && count($notification_type->roles) > 0) {
            foreach ($notification_type->roles as $role) {
                if (count($role->users) > 0) {
                    foreach ($role->users as $user) {
                        if (!in_array($user->id, $users_temp)) {
                            $users_temp[] = $user->id;
                            notify($message, $user);
                        }
                    }
                }
            }
        }

    }
}
