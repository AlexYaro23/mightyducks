<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    const LOGO = '/img/mightyducks/md_final.png';
    const SHIRT = '/img/mightyducks/final_final.jpg';

    protected $fillable = [
        'mls_id',
        'name',
        'link'
    ];

    public $timestamps = false;

    public function player()
    {
        return $this->hasOne('App\Models\Player');
    }

    public function getLogoLink()
    {
        return self::LOGO;
    }

    public function getShirtLink()
    {
        return self::SHIRT;
    }
}
