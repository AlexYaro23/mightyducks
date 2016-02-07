<?php

namespace App\Repositories;

use App\Models\Stat;
use Illuminate\Support\Facades\DB;

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

    public static function getPlayersStatistics($playerList)
    {
        $data = [];

        $stats = DB::table('stats')
            ->select(DB::raw('player_id, COALESCE(sum(visit),0) as visits, COALESCE(sum(goal),0) as goals,
            COALESCE(sum(assist),0) as assists, COALESCE(sum(yc),0) as ycs, COALESCE(sum(rc),0) as rcs'))
            ->whereIn('player_id', $playerList->lists('id')->all())
            ->groupBy('player_id')
            ->get();

        foreach ($stats as $stat) {
            $data[$stat->player_id] = $stat;
        }

        $result = [];

        foreach ($playerList as $player) {
            $result[$player->id] = isset($data[$player->id]) ? $data[$player->id] : self::getEmptyStat();
        }

        return $result;
    }

    private static function getEmptyStat()
    {
        $emptyStat = new \stdClass();
        $emptyStat->visits = 0;
        $emptyStat->goals = 0;
        $emptyStat->assists = 0;
        $emptyStat->ycs = 0;
        $emptyStat->rcs = 0;

        return $emptyStat;
    }

    public static function getByPlayerId($player_id)
    {
        $stats = DB::table('stats')
            ->select(DB::raw('COALESCE(sum(visit),0) as visits, COALESCE(sum(goal),0) as goals,
            COALESCE(sum(assist),0) as assists, COALESCE(sum(yc),0) as ycs, COALESCE(sum(rc),0) as rcs'))
            ->where('player_id', $player_id)
            ->groupBy('player_id')
            ->first();

        return $stats ? $stats : self::getEmptyStat();
    }

    public static function getStatsByGameId($game_id)
    {
        $stats[Stat::GOAL] = Stat::where('game_id', $game_id)->whereNotNull(Stat::GOAL)->get();
        $stats[Stat::ASSIST] = Stat::where('game_id', $game_id)->whereNotNull(Stat::ASSIST)->get();
        $stats[Stat::YELLOW_CARD] = Stat::where('game_id', $game_id)->whereNotNull(Stat::YELLOW_CARD)->get();
        $stats[Stat::RED_CARD] = Stat::where('game_id', $game_id)->whereNotNull(Stat::RED_CARD)->get();

        return $stats;
    }
}