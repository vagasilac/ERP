<?php

namespace App\Models;

use C4studio\Notification\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];



    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }



    /**
     * Grant the given permission to a role.
     *
     * @param  Permission $permission
     * @return mixed
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * Check if role has permission.
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return !! $permission->intersect($this->$permission)->count();
    }


    /**
     * A role may be given various notification types.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notification_types()
    {
        return $this->belongsToMany('App\Models\NotificationType');
    }

    /**
     * Check if role has a notification type.
     *
     * @param $notification_type
     * @return bool
     * @internal param $permission
     */
    public function hasNotificationTypeSet($notification_type)
    {
        if (is_string($notification_type)) {
            return $this->notification_types->contains('name', $notification_type);
        }

        return !! $notification_type->intersect($this->$notification_type)->count();
    }

    /**
     * Get users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function internal_audit_reports()
    {
        return $this->belongsToMany('App\Models\InternalAuditReport', 'internal_audit_report_audited', 'role_id', 'internal_report_id');
    }

    public function management_review_meeting_absents()
    {
        return $this->belongsToMany('App\Models\ManagementReviewMeeting', 'management_review_absents', 'role_id', 'management_review_id');
    }

    public function management_review_meeting_attendances()
    {
        return $this->belongsToMany('App\Models\ManagementReviewMeeting', 'management_review_attendances', 'role_id', 'management_review_id');
    }
}
