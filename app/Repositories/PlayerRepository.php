<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository
{
    public static function getListByTeamId($teamId)
    {
        return Player::where('team_id', $teamId)->get();
    }

    public static function getActiveListByTeamId($teamId)
    {
        return Player::where('team_id', $teamId)->active()->get();
    }

    public static function getFilteredPlayers($request)
    {

    }
}