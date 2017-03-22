<?php

namespace App\Models\Api;

class Visit
{
    public $value;
    public $canSelect;
    public $playerId;
    public $playerName;

    public function __construct($stat, $player, $authorizedPlayerId, $enabled)
    {
        $this->value = $stat;
        $this->playerId = $player->id;
        $this->playerName = $player->name;
        $this->canSelect = $player->id === $authorizedPlayerId && $enabled;
    }
}