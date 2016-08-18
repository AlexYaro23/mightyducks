<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

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
        $visitMap = ['' => ''] + Stat::$visitList;
        $visitList = StatRepository::getActiveVisitsForGame($game->id);

        $visitList = $visitList->lists(Stat::VISIT, 'player_id');

        return view('backend.visits.edit')
            ->with('playerList', $playerList)
            ->with('visitList', $visitList)
            ->with('visitMap', $visitMap)
            ->with('game', $game);
    }

    public function store(Request $request)
    {
        GameRepository::saveQuickVisit($request);

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.visits'));
    }
}