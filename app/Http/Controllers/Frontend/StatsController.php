<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Repositories\PlayerRepository;
use App\Repositories\StatRepository;
use App\Repositories\TournamentRepository;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $team = Team::find(config('mls.team_id'));

        $playerList = PlayerRepository::getListByTeamId($team->id);

        $tournamentList = TournamentRepository::getListByTeamId($team->id);

        $selectedPlayerList = $request->get('playerList');
        $selectedTournamentList = $request->get('tournamentList');

        $filterPlayerList = $selectedPlayerList ? $selectedPlayerList : $playerList->lists('id')->all();

        $statList = StatRepository::getFilteredPlayersStatistics($filterPlayerList, $selectedTournamentList);

        return view('frontend.stats.view')
            ->with('team', $team)
            ->with('playerList', $playerList)
            ->with('statList', $statList)
            ->with('tournamentList', $tournamentList->lists('name', 'id'))
            ->with('selectedPlayerList', $selectedPlayerList)
            ->with('selectedTournamentList', $selectedTournamentList);
    }
}