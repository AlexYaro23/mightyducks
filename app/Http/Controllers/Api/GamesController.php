<?php

namespace App\Http\Controllers\Api;

use App\Events\GameVisitChange;
use App\Http\Controllers\Controller;
use App\Models\Api\Game;
use App\Models\Game as GameModel;
use App\Models\Api\Visit;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\GameRepository;

use App\Http\Requests;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GamesController extends Controller
{
	const NEXT_GAMES_COUNT = 3;
	const LAST_GAMES_COUNT = 3;

	public function next($limit)
    {
		$team = Team::find(config('mls.team_id'));

        $limit = is_numeric($limit) ? $limit : self::LAST_GAMES_COUNT;

		$nextGames = GameRepository::getNextInSchedule($team->id, $limit);

        $result = collect([]);

        foreach ($nextGames as $game) {
            $result->push(new Game($game, $team->name));
        }

		return $result;
    }

    public function last($limit)
    {
        $team = Team::find(config('mls.team_id'));

        $limit = is_numeric($limit) ? $limit : self::LAST_GAMES_COUNT;

        $lastGames = GameRepository::getLastFinished($team->id, $limit);

        $result = collect([]);

        $players = PlayerRepository::getListByTeamId($team->id);
        $playerIdNameMap = $players->lists('name', 'id');

        foreach ($lastGames as $game) {
            $stats = StatRepository::getStatsByGameId($game->id);

            $apiGame = new Game($game, $team->name);
            $apiGame->loadStats($stats, $playerIdNameMap);

            $result->push($apiGame);
        }



        return $result;
    }

    public function get(GameModel $game)
    {
        $team = Team::find(config('mls.team_id'));

        $gameApi = new Game($game);

        $siblings = GameRepository::getSiblings($game);
        $gameApi->loadSiblings($siblings);

        $authorizedPlayerId = null;
        $user = \Auth::user();
        if ($user && $user->player) {
            $authorizedPlayerId = $user->player->id;
        }
        $players = PlayerRepository::getActiveListByTeamId($team->id);
        $visits = StatRepository::getVisitsForGame($game->id)->pluck(Stat::VISIT, 'player_id');

        $visitsApi = [];
        $enabledVisit = $game->isEditable();
        foreach ($players as $player) {
            $stat = $visits[$player->id] ?? 0;
            $visitsApi[] = new Visit($stat, $player, $authorizedPlayerId, $enabledVisit);
        }

        $gameApi->visits = $visitsApi;

        return response()->json($gameApi);
    }

    public function updateVisit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required|integer|exists:games,id',
                'value' => 'in:' . Stat::GAME_VISITED . ',' . Stat::GAME_NOT_VISITED
            ]

        );

        if (
            !$validator->fails() &&
            Auth::user() != null &&
            Auth::user()->player != null
        ) {
            $data['game_id'] = $request->get('game_id');
            $data['player_id'] = Auth::user()->player->id;
            StatRepository::createOrUpdateGameVisit($data, $request->get('value'));

            $data['visit'] = $request->get('value');
            event(new GameVisitChange($data));

            return json_encode(['msg' => trans('frontend.main.visit_added'), 'status' => 'success']);
        }

        return json_encode(['msg' => trans('frontend.main.visit_add_err'), 'status' => 'error']);
    }
}
