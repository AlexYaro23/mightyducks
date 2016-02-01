<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;

class MainController extends Controller
{
    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);
        $game = GameRepository::getNextGameByTeamId($team->id);

        return view('frontend.main.index')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('game', $game);
    }
}