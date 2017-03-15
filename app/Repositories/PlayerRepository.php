<?php

namespace App\Repositories;

use App\Models\Player;
use \DB;

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

    public static function getFilteredPlayers($playerIds, $leagueIds, $tournamentsIds)
    {
        $query = DB::table('players')
            ->join('player2tournament', 'player2tournament.player_id', '=', 'players.id')
            ->join('tournaments', 'tournaments.id', '=', 'player2tournament.tournament_id')
            ->select('players.id');

        if (!empty($playerIds)) {
            $query->whereIn('players.id', $playerIds);
        }

        if (!empty($leagueIds)) {
            $query->whereIn('tournaments.league_id', $leagueIds);
        }

        if (!empty($tournamentsIds)) {
            $query->whereIn('tournaments.id', $tournamentsIds);
        }

        $rows = $query->get();

        $ids = [];

        foreach ($rows as $row) {
            if (!in_array($row->id, $ids)) {
                $ids[] = $row->id;
            }
        }

        $players = !empty($ids) ? Player::whereIn('id', $ids)->get() : [];

        return $players;
    }
}