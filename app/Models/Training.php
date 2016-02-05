<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    const STATUS_ACITVE = 1;
    const STATUS_PASSIVE = 2;

    protected static $statusList = [
        self::STATUS_ACITVE => 'Active',
        self::STATUS_PASSIVE => 'Passive'
    ];

    protected $fillable = [
        'name',
        'address',
        'day_of_week',
        'time',
        'status',
        'next_date',
        'team_id'
    ];

    protected $dates = ['next_date'];

    protected static $dayOfWeekList = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday'
    ];

    public $timestamps = false;

    public static function getDayOfWeekList()
    {
        return self::$dayOfWeekList;
    }

    public static function getStatusList()
    {
        return self::$statusList;
    }

    public function getTime()
    {
        return date('H:i', strtotime($this->time));
    }
}
