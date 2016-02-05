<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const PHOTO_PATH = '/img/team_logos/';
    const PHOTO_TYPE = '.png';
    const DEFAULT_PHOTO = '/img/team_logos/default.png';
    const MSG_SENT = 2;
    const MSG_NOT_SENT = 1;

    protected $fillable = [
        'team_id',
        'team',
        'date',
        'score1',
        'score2',
        'home',
        'status',
        'reminder',
        'place',
        'round',
        'tournament_id',
        'mls_id',
        'mls_url'
    ];

    protected $dates = ['date'];

    protected static $statusList = [
        1 => 'None played',
        2 => 'Played',
        3 => 'Only result'
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

    public static function getPlayedStatus()
    {
        return 2;
    }

    public static function getOnlyResultStatus()
    {
        return 3;
    }

    public function isHome()
    {
        return $this->home == 1 ? true : false;
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

    public function isEditable()
    {
        return $this->date >= Carbon::now() ? true : false;
    }

    public function tournament()
    {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function getTeanPhotoLink()
    {
        if (file_exists(public_path() . self::PHOTO_PATH . $this->team . self::PHOTO_TYPE)) {
            return self::PHOTO_PATH . $this->team . self::PHOTO_TYPE;
        } else {
            return self::DEFAULT_PHOTO;
        }
    }

    public function isPlayed()
    {
        if (isset($this->score1) && $this->score1) {
            return true;
        }

        return false;
    }
}
