<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'game_id',
        'player_id',
        'parameter',
        'value'
    ];

    protected static $parameterList = [
        'played' => 'Played',
        'goal' => 'Goal',
        'assist' => 'Assist',
        'yc' => 'Yellow Card',
        'rc' => 'Red Card'
    ];

    public static function getParameterList()
    {
        return self::$parameterList;
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
