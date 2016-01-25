<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name', 'email', 'provider_id', 'status', 'screen_name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $phoroDir;

    protected static $statuses = [
        1 => 'active',
        2 => 'banned'
    ];

    /**
     * @return mixed
     */
    public function getPhoroDir()
    {
        return $this->phoroDir;
    }

    public static function getStatuses()
    {
        return self::$statuses;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role2user');
    }

    public function getRoleListAttribute()
    {
        return $this->roles->lists('id');
    }

    public function hasRole($searchRole)
    {
        foreach ($this->roles->lists('name') as $role) {
            if ($searchRole == $role) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function player()
    {
        return $this->hasOne('App\Models\Player');
    }
}
