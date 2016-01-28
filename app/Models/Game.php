<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'team_id',
        'team',
        'date',
        'score1',
        'score2',
        'home',
        'status',
        'place',
        'round',
        'tournament_id',
        'mls_id',
        'mls_url'
    ];

    protected static $statusList = [
        1 => 'None played',
        2 => 'Played'
    ];

    protected static $homeList = [
        1 => 'Home',
        2 => 'Visitor'
    ];

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return self::$statusList;
    }

    /**
     * @return array
     */
    public static function getHomeList()
    {
        return self::$homeList;
    }

    public static function getNonePlayedStatus()
    {
        return 1;
    }


    public function setScore1Attribute($score1)
    {
        $this->attributes['score1'] = trim($score1) !== '' ? $score1 : null;
    }


    public function setScore2Attribute($score2)
    {
        $this->attributes['score2'] = trim($score2) !== '' ? $score2 : null;
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::parse($date);
    }
}
