<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    const PLAYED = 'played';

    protected $fillable = [
        'game_id',
        'player_id',
        'parameter',
        'value'
    ];

    protected static $parameterList = [
        self::PLAYED => 'Played',
        'goal' => 'Goal',
        'assist' => 'Assist',
        'yc' => 'Yellow Card',
        'rc' => 'Red Card'
    ];

    public static function getParameterList()
    {
        return self::$parameterList;
    }

    public static function getParameterVisit()
    {
        return self::PLAYED;
    }

    public static function getValueVisit($visit)
    {
        return $visit == 'true' ? 1: 2;
    }

    public function player()
    {
        return $this->belongsTo('App\Models\Player');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }
}
