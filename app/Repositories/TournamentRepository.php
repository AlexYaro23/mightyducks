<?php

namespace App\Repositories;

use App\Models\Tournament;

class TournamentRepository
{
    public function getActiveScheduled()
    {
        return Tournament::whereNotNull('link')->where('status', Tournament::STATUS_ACTIVE)->get();
    }

    public function getPassive()
    {
        return Tournament::whereNotNull('link')->where('status', Tournament::STATUS_PASSIVE)->get();
    }

    public static function getListByTeamId($teamId)
    {
        return Tournament::whereNotNull('link')->where('team_id', $teamId)->get();
    }
}