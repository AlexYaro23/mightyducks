<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Player extends Model
{
    const PHOTO_PATH = '/img/avatars/players/';
    const PHOTO_TYPE = '.jpg';
    const DEFAULT_PHOTO = '/img/avatars/default.png';

    const ACTIVE = 1;
    const FINISHED = 2;

    public static $statuses = [
        self::ACTIVE => 'active',
        self::FINISHED => 'finished'
    ];

    protected $fillable = [
        'user_id',
        'mls_id',
        'team_id',
        'name',
        'date_of_birth',
        'position',
        'status',
        'telegram_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function getPhotoLink()
    {

        if (isset($this->id) && file_exists(public_path() . self::PHOTO_PATH . $this->id . self::PHOTO_TYPE)) {
            return self::PHOTO_PATH . $this->id . self::PHOTO_TYPE;
        } else {
            return self::DEFAULT_PHOTO;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function tournaments()
    {
        return $this->belongsToMany('App\Models\Tournament', 'player2tournament', 'player_id', 'tournament_id');
    }

    public function getShortName()
    {
        $parts = preg_split('/\s+/', $this->name);
        $name = $parts[0];
        if (isset($parts[1])) {
            $name .= ' ' . $parts[1];
        }

        return $name;
    }
}
