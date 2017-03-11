<?php

namespace App\Models\Api;

use App\Models\Player as PlayerModel;

class Player
{
    public $id;
    public $name;
    public $photo;
    public $visits;
    public $goals;
    public $assists;
    public $ycs;
    public $rcs;

    private $statsMap = [
        'visits' => 'visits',
        'goals' => 'goals',
        'assists' => 'assists',
        'ycs' => 'ycs',
        'rcs' => 'rcs'
    ];

    public function __construct(PlayerModel $player)
    {
        $this->id = $player->id;
        $this->name = $player->name;
        $this->photo = url($player->getPhotoLink());
    }

    public function loadStats($stats)
    {
        foreach ($this->statsMap as $key => $property) {
            $this->{$property} = $stats->{$key};
        }
    }
}