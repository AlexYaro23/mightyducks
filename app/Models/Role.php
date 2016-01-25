<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    private static $roleIds = [
        'admin' => 1,
        'player' => 2,
        'user' => 3
    ];

    private static $defaultRole = 'user';
    private static $adminRole = 'admin';

    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = false;

    public static function getDefaultRole()
    {
        return self::$roleIds[self::$defaultRole];
    }

    public static function getAdminRole()
    {
        return self::$roleIds[self::$adminRole];
    }


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role2user');
    }

    public function getAdminRoleId()
    {
        return $this->roles['admin'];
    }

    public function getPlayerRoleId()
    {
        return $this->roles['player'];
    }

    public function getUserRoleId()
    {
        return $this->roles['user'];
    }
}
