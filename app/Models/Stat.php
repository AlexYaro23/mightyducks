<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    const VISIT = 'visit';
    const GOAL = 'goal';
    const ASSIST = 'assist';
    const YELLOW_CARD = 'yc';
    const RED_CARD = 'rc';

    const GAME_VISITED = 1;
    const GAME_NOT_VISITED = 2;



    protected $fillable = [
        'game_id',
        'player_id',
        'visit',
        'goal',
        'assist',
        'yc',
        'rc'
    ];

    protected static $parameterList = [
        self::VISIT => 'Played',
        self::GOAL => 'Goal',
        self::ASSIST => 'Assist',
        self::YELLOW_CARD => 'Yellow Card',
        self::RED_CARD => 'Red Card'
    ];

    public static function getGameVisitedValue()
    {
    }

    public static function convertVisitValue($visit)
    {
        return $visit == 'true' ? self::GAME_VISITED : self::GAME_NOT_VISITED;
    }

    public static function getParameterList()
    {
        return self::$parameterList;
    }

    public static function getParameterKeys()
    {
        return array_keys(self::$parameterList);
    }

    public static function getParameterVisit()
    {
        return self::VISIT;
    }



    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    public function getParameterAttribute()
    {
        $keyList = self::getParameterKeys();
        $paramList = self::getParameterList();
        foreach ($keyList as $key) {
            if (isset($this->$key) && $this->$key !== null) {
                return $paramList[$key];
            }
        }
    }

    public function getValueAttribute()
    {
        $keyList = self::getParameterKeys();
        foreach ($keyList as $key) {
            if (isset($this->$key) && $this->$key !== null) {
                return $this->$key;
            }
        }
    }
}
