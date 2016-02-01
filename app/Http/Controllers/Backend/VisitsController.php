<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\StatRepository;

class VisitsController extends Controller
{
    public function index()
    {
        $gameList = Game::all();

        return view('backend.visits.list')->with('gameList', $gameList);
    }

    public function edit(Game $game)
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = Player::where('team_id', $team->id)->get();

        $visitList = StatRepository::getVisitsForGame($game->id);

        $visitList = $visitList->lists(Stat::VISIT, 'player_id');

        return view('backend.visits.edit')
            ->with('playerList', $playerList)
            ->with('visitList', $visitList)
            ->with('game', $game);
    }
}