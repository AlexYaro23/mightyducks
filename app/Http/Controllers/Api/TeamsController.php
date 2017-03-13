<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Team;
use App\Models\Team as TeamModel;
use App\Repositories\GameRepository;
use App\Http\Controllers\Controller;

class TeamsController extends Controller
{
    public function stats()
    {
        $team = TeamModel::find(config('mls.team_id'));
        $teamApi = new Team($team);

        $gameList = GameRepository::getListByTeamId($team->id);
        $teamApi->addStats($gameList);

        return response()->json($teamApi);
    }
}