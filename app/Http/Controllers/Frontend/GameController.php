<?php

namespace App\Http\Controllers\Frontend;

use App\Events\GameVisitChange;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Stat;
use App\Models\Team;
use App\Models\Tournament;
use App\Repositories\GameRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function index()
    {
        $team = Team::find(config('mls.team_id'));
        $gameList = GameRepository::getListByTeamId($team->id);
        $tournamentList = Tournament::all();
        $tournamentList = $tournamentList->lists('name', 'id');

        return view('frontend.game.list')
            ->with('team', $team)
            ->with('gameList', $gameList)
            ->with('tournamentList', $tournamentList);
    }


    public function view(Game $game)
    {
        $team = Team::find(config('mls.team_id'));
        $statList = StatRepository::getStatsByGameId($game->id);
        $playerList = PlayerRepository::getListByTeamId($game->team_id);
        $statGroupList = Stat::getParameterKeys();

        return view('frontend.game.view')
            ->with('game', $game)
            ->with('statList', $statList)
            ->with('playerList', $playerList->lists('name', 'id'))
            ->with('team', $team)
            ->with('statGroupList', $statGroupList);
    }

    public function addVisit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required|integer|exists:games,id',
                'team_id' => 'required|integer|exists:teams,id',
                'visit' => 'in:' . Stat::GAME_VISITED . ',' . Stat::GAME_NOT_VISITED
            ]

        );

        if (
            !$validator->fails() &&
            Auth::user() != null &&
            Auth::user()->player != null &&
            Auth::user()->player->team != null &&
            Auth::user()->player->team->id == $request->get('team_id')
        ) {
            $data['game_id'] = $request->get('game_id');
            $data['player_id'] = Auth::user()->player->id;
            StatRepository::createOrUpdateGameVisit($data, $request->get('visit'));

            $data['visit'] = $request->get('visit');
            event(new GameVisitChange($data));

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
            ->with('gameSiblings', $gameSiblings)
            ->with('statusVisited', Stat::GAME_VISITED)
            ->with('statusNotVisited', Stat::GAME_NOT_VISITED);
    }
}