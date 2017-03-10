<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Game;
use App\Models\Stat;
use App\Models\Team;
use App\Repositories\GameRepository;

use App\Http\Requests;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;

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
//    	return [
//    		[
//    			'teamB' => 'Express Kindness', 'logoB' => 'logo.png', 'date' => '21:30 01-02-2017', 'place' => 'Politeh', 'round' => '3rd Round',
//    			'teamA' => 'MightyDucks', 'goalsA' => '4', 'goalsB' => '5', 'logoA' => 'logo.png', 'championship' => 'Winter Championship',
//    			'scorers' => ['Yaromenko', 'Capibara', 'Ovchinnikov'], 'assistants' => ['Ovchinnikov', 'Kuharenko']
//    		],
//    		[
//    			'teamB' => 'Energy', 'logoB' => 'logo.png', 'date' => '19:30 05-02-2017', 'place' => 'Politeh', 'round' => '4rd Round',
//    			'teamA' => 'MightyDucks', 'goalsA' => '4', 'goalsB' => '5', 'logoA' => 'logo.png', 'championship' => 'Winter Championship',
//    			'scorers' => ['Yaromenko', 'Ovchinnikov'], 'assistants' => ['Ovchinnikov', 'Kuharenko'], 'ycs' => ['Ovchinnikov', 'Kuharenko']
//    		]
//    	];
    }
}
