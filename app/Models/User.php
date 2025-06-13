<?php

namespace App\Models;

use C4studio\Notification\Traits\HasNotifications;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasNotifications;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['dob'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'personal_email', 'password', 'job_title', 'address', 'city', 'county', 'country', 'phone', 'personal_phone', 'dob', 'id_card', 'bank_account', 'locker_room_number', 'rfid', 'photo', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get user name.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function name()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }



    /**
     * Assign the given role to the user.
     *
     * @param  integer $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::findOrFail($role)
        );
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRoleByName($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission)
    {
        return $this->hasRole($permission->roles);
    }

}
