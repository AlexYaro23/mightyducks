<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use App\Repositories\TrainingRepository;

class TeamsController extends Controller
{
    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);
        $gameList = GameRepository::getListByTeamId($team->id);
        $trainingList = TrainingRepository::getActiveList($team->id);
        $statList = StatRepository::getPlayersStatistics($playerList);

        return view('frontend.teams.view')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('gameList', $gameList)
            ->with('trainingList', $trainingList)
            ->with('statList', $statList);
    }
}