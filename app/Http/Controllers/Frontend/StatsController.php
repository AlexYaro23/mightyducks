<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;

class StatsController extends Controller
{
    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);
        $statList = StatRepository::getPlayersStatistics($playerList);

        return view('frontend.stats.view')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('statList', $statList);
    }

    public function view()
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);
        $statList = StatRepository::getPlayersStatistics($playerList);

        return view('frontend.stats.view')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('statList', $statList);
    }
}