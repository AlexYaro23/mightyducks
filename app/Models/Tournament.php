<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name',
        'link',
        'status'
    ];

    protected static $statusList = [
        1 => 'Active',
        2 => 'Finished'
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
