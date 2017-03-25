<?php

namespace App\Repositories;

use App\Models\Tournament;

class TournamentRepository
{
    public function getActiveScheduled($league_id)
    {
        return Tournament::where('league_id', $league_id)->whereNotNull('link')->where('status', Tournament::STATUS_ACTIVE)->get();
    }

    public function getPassive()
    {
        return Tournament::whereNotNull('link')->where('status', Tournament::STATUS_PASSIVE)->get();
    }

    public static function getListByTeamId($teamId)
    {
        return Tournament::whereNotNull('link')->where('team_id', $teamId)->get();
    }

    public static function getIdsForLeague($leagueId)
    {
        return Tournament::where('league_id', $leagueId)->get()->pluck('id')->toArray();
    }
}