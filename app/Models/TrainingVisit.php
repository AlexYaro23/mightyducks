<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TrainingVisit extends Model
{
    const VISITED = 1;
    const NOT_VISITED = 2;

    protected $fillable = [
        'training_id',
        'player_id',
        'visit'
    ];

    public $timestamps = false;

    protected static $visitList = [
        self::VISITED => 'Yes',
        self::NOT_VISITED => 'No'
    ];

    public static function getVisitList()
    {
        return self::$visitList;
    }

    public static function convetValue($visit)
    {
        return $visit == 'true' ? self::VISITED : self::NOT_VISITED;
    }
}
