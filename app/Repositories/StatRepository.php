<?php

namespace App\Repositories;

use App\Models\Stat;

class StatRepository
{
    public static function createOrUpdateGameVisit(array $data, $visit)
    {
        $stat = Stat::where('game_id', $data['game_id'])
            ->where('player_id', $data['player_id'])
            ->whereNotNull(Stat::VISIT)->first();

        if (!$stat) {
            Stat::create([
                'game_id' => $data['game_id'],
                'player_id' => $data['player_id'],
                Stat::VISIT => Stat::convertVisitValue($visit)
            ]);
        } else {
            $stat->visit = Stat::convertVisitValue($visit);

            $stat->save();
        }
    }

    public static function getVisitsForGame($gameId)
    {
        return Stat::where('game_id', $gameId)->where(Stat::VISIT, Stat::GAME_VISITED)->get();
    }

    public static function addVisit($game_id, $player_id)
    {
        $stat = Stat::where('game_id', $game_id)
            ->where('player_id', $player_id)
            ->whereNotNull(Stat::VISIT)
            ->first();

        if ($stat) {
            $stat->{Stat::VISIT} = Stat::GAME_VISITED;

            $stat->save();
        } else {
            Stat::create([
                'game_id' => $game_id,
                'player_id' => $player_id,
                Stat::VISIT => Stat::GAME_VISITED
            ]);
        }
    }
}