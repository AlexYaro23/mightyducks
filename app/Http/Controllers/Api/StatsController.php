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

class StatsController extends Controller
{
	public function add(Request $request)
    {
        Stat::create([
            'game_id' => $request->get('game_id'),
            'player_id' => $request->get('player_id'),
            $request->get('parameter') => $request->get('value')
        ]);
    }

    public function remove(Request $request)
    {
        $stat = Stat::find($request->get('id'));

        if ($stat) {
            $stat->delete();
        }
    }
}
