<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Player;
use App\Models\Team;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use App\Http\Controllers\Controller;

class PlayersController extends Controller
{
    public function all()
    {
        $playersApi = [];
        $team = Team::find(config('mls.team_id'));

        $players = PlayerRepository::getActiveListByTeamId($team->id);

        foreach ($players as $player) {
            $stats = StatRepository::getByPlayerId($player->id);

            $playerApi = new Player($player);
            $playerApi->loadStats($stats);

            array_push($playersApi, $playerApi);
        }

        return $playersApi;
    }
}