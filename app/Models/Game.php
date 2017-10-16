<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const PHOTO_PATH = '/img/team_logos/';
    const PHOTO_TYPE = '.png';
    const DEFAULT_PHOTO = '/img/team_logos/default.png';
    const MSG_SENT = 3;
    const MSG_NOT_SENT = 1;
    const MSG_CLOSED = 2;
    const HOME = 1;
    const VISITOR = 2;

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
        'mls_url',
        'youtube',
        'description',
        'telegram_msg_id'
    ];

    protected $dates = ['date'];

    protected static $statusList = [
        1 => 'None played',
        2 => 'Played',
        3 => 'Only result'
    ];

    protected static $homeList = [
        self::HOME => 'Home',
        self::VISITOR => 'Visitor'
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

    public function getTeamPhotoLink()
    {
        if (file_exists(public_path() . self::PHOTO_PATH . str2url($this->team) . self::PHOTO_TYPE)) {
            return self::PHOTO_PATH . str2url($this->team) . self::PHOTO_TYPE;
        } else {
            return self::DEFAULT_PHOTO;
        }
    }

    public function isPlayed()
    {
        if (isset($this->score1) && $this->score1 !== null) {
            return true;
        }

        return false;
    }

    public function getVoteMsg($platform)
    {
        $month_en = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $month_ru = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
        $days = [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье'
        ];

        $msg = config('mls.chat_game_msg_' . $platform);
        $msg = str_replace('%date%', $days[$this->date->format('N')] . $this->date->format(' (d M)'),  $msg);
        $msg = str_replace('%time%', $this->date->format('H:i'),  $msg);
        $msg = str_replace($month_en, $month_ru, $msg);
        $msg = str_replace('%team%', $this->team, $msg);
        $msg = str_replace('%place%', $this->place, $msg);
        $msg = str_replace('%url%', route('game.visit', ['id' => $this->id]), $msg);

        return $msg;
    }

    public function getVideoMsg()
    {
        $msg = config('mls.video_msg');
        $msg = sprintf($msg, $this->youtube);

        return $msg;
    }
}
