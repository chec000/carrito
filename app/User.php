<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name', 'email', 'password','username','country_id','role_id','modified_id','estatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function hasRole($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                if ($role->alias == $name) {
                    return true;
                }
            }
        }

        return false;
    }
    public function hasPermission($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->hasPermission($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                // Validate against the Permission table
                foreach ($role->permissions as $perm) {
                    if ($perm->alias == $permission) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
    public function PermisosUser($idPermiso)
    {
        $permiso = DB::table('permission_role')
            ->where('role_id',Auth::user()->roles[0]->id)
            ->where('permission_id',$idPermiso)
            ->first();
        return isset($permiso);
    }
    public static function obtainRolesFromUser($userId)
    {
        return DB::table('role_user')
            ->select(DB::raw('GROUP_CONCAT(roles.name SEPARATOR "<br/>") as roles'))
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.user_id', $userId)
            ->first()->roles;
    }

    /*
     * relationships
     */


    public function roles() {
//        return $this->hasOne('App\Role', 'id','role_id');
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function rol() {
        return $this->hasOne('App\Role', 'id','role_id');
    }

    public function country() {
        return $this->hasOne('App\Country', 'country_id','country_id');
    }

}
