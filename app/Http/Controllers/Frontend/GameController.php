<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function view(Game $game)
    {
        dd($game);
    }

    public function addVisit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required|integer|exists:games,id',
                'team_id' => 'required|integer|exists:teams,id',
                'visit' => 'required|in:true,false'
            ]

        );

        if (
            !$validator->fails() &&
            isset(Auth::user()->player->id) &&
            isset(Auth::user()->player->team->id) &&
            Auth::user()->player->team->id == $request->get('team_id')
        ) {
            $data['game_id'] = $request->get('game_id');
            $data['player_id'] = Auth::user()->player->id;
            StatRepository::createOrUpdateGameVisit($data, $request->get('visit'));

            return json_encode(['msg' => trans('frontend.main.visit_added'), 'status' => 'success']);
        }

        return json_encode(['msg' => trans('frontend.main.visit_add_err'), 'status' => 'error']);
    }

    public function showVisit(Game $game)
    {
        $team = Team::find(config('mls.team_id'));
        $playerList = PlayerRepository::getListByTeamId($team->id);

        if (!isset($game->id)) {
            $game = GameRepository::getNextGameByTeamId($team->id);
        }

        if (!$game) {
            return view('frontend.game.no_game');
        }

        $gameSiblings = GameRepository::getSiblings($game);

        $visitList = StatRepository::getVisitsForGame($game->id);

        $visitList = $visitList->lists(Stat::VISIT, 'player_id');

        return view('frontend.game.index')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('game', $game)
            ->with('visitList', $visitList)
            ->with('gameSiblings', $gameSiblings);
    }
}