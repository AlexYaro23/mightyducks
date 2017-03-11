<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 2;
    const LOGO_PATH = '/img/leagues/';
    const LOGO_EXT = '.png';
    const DEFAULT_LOGO = '/img/team_logos/default.png';

    private $logo;

    protected $fillable = [
        'name',
        'link',
        'status',
        'info'
    ];

    protected static $statusList = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_PASSIVE => 'Finished'
    ];

    public function setLinkAttribute($link)
    {
        $this->attributes['link'] = trim($link) !== '' ? $link : null;
    }

    public static function getStatusList()
    {
        return self::$statusList;
    }

    public function getLogoLink()
    {
        if ($this->hasLogo()) {
            return self::LOGO_PATH . $this->id . self::LOGO_EXT;
        }

        return self::DEFAULT_LOGO;
    }

    public function hasLogo()
    {
        return isset($this->id) && file_exists(public_path() . self::LOGO_PATH . $this->id . self::LOGO_EXT);
    }
}
