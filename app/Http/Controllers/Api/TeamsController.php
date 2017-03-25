<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Team;
use App\Models\Team as TeamModel;
use App\Repositories\GameRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function stats(Request $request)
    {
        $team = TeamModel::find(config('mls.team_id'));
        $teamApi = new Team($team);

        if ($request->get('leagueId')) {
            $gameList = GameRepository::getListByTeamIdForLeague($team->id, $request->get('leagueId'));
        } else {
            $gameList = GameRepository::getListByTeamId($team->id);
        }

        $teamApi->addStats($gameList);

        return response()->json($teamApi);
    }
}