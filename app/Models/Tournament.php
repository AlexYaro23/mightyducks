<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 2;

    protected $fillable = [
        'name',
        'link',
        'status',
        'team_id'
    ];

    protected static $statusList = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_PASSIVE => 'Finished'
    ];

    public $timestamps = false;

    public function setLinkAttribute($link)
    {
        $this->attributes['link'] = trim($link) !== '' ? $link : null;
    }

    public static function getStatusList()
    {
        return self::$statusList;
    }
}
